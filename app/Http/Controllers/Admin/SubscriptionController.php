<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Exception\ApiErrorException;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Show the payment form for creating a subscription.
     */
    public function create(Website $website, Request $request): View
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to manage this website subscription.');
        }

        $request->validate([
            'plan' => ['required', 'in:basic,pro'],
        ]);

        $plan = $request->plan;
        $priceId = Website::getStripePriceIds()[$plan];
        $planPrice = $plan === 'basic' ? 99 : 169;

        return view('admin.websites.subscriptions.create', [
            'website' => $website,
            'plan' => $plan,
            'planPrice' => $planPrice,
            'priceId' => $priceId,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    /**
     * Process the subscription payment and create the subscription.
     */
    public function store(Website $website, Request $request): JsonResponse
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            return response()->json(['error' => 'You do not have permission to manage this website subscription.'], 403);
        }

        // Manually validate to ensure JSON response
        $plan = $request->input('plan');
        $paymentMethodId = $request->input('payment_method_id');
        
        $errors = [];
        if (!$plan || !in_array($plan, ['basic', 'pro'])) {
            $errors[] = 'Plan is required and must be basic or pro';
        }
        if (!$paymentMethodId || !is_string($paymentMethodId)) {
            $errors[] = 'Payment method ID is required';
        }
        
        if (!empty($errors)) {
            return response()->json([
                'error' => 'Validation failed: ' . implode(', ', $errors),
            ], 422);
        }

        $priceId = Website::getStripePriceIds()[$plan];

        try {
            // Get or create Stripe customer
            $customerId = $website->stripe_id;
            if (!$customerId) {
                $customer = Customer::create([
                    'email' => $website->user->email,
                    'name' => $website->user->full_name,
                    'description' => $website->name,
                    'metadata' => [
                        'website_id' => $website->id,
                    ],
                ]);
                $customerId = $customer->id;
            } else {
                $customer = Customer::retrieve($customerId);
                // Keep customer description in sync with website title
                Customer::update($customerId, ['description' => $website->name]);
            }

            // Attach payment method to customer (but don't set as default)
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $customerId]);

            // Don't attach payment method yet - create subscription first to get payment intent
            // With default_incomplete and NO payment method, Stripe MUST create a payment intent
            $subscription = Subscription::create([
                'customer' => $customerId,
                'items' => [[
                    'price' => $priceId,
                ]],
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => [
                    'save_default_payment_method' => 'on_subscription',
                ],
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'website_id' => $website->id,
                    'plan' => $plan,
                ],
            ]);
            
            // Now attach payment method to customer (for saving later)
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $customerId]);

            // Get payment intent from subscription
            $paymentIntent = null;
            $invoiceId = null;
            
            // Try to get invoice ID
            if (isset($subscription->latest_invoice)) {
                if (is_object($subscription->latest_invoice)) {
                    $invoiceId = $subscription->latest_invoice->id ?? null;
                    // Check if payment_intent is already expanded
                    if (isset($subscription->latest_invoice->payment_intent)) {
                        if (is_object($subscription->latest_invoice->payment_intent)) {
                            $paymentIntent = $subscription->latest_invoice->payment_intent;
                        } elseif (is_string($subscription->latest_invoice->payment_intent)) {
                            // Payment intent is just an ID, retrieve it
                            $paymentIntent = \Stripe\PaymentIntent::retrieve($subscription->latest_invoice->payment_intent);
                        }
                    }
                } elseif (is_string($subscription->latest_invoice)) {
                    $invoiceId = $subscription->latest_invoice;
                }
            }
            
            // If we have invoice ID but no payment intent, retrieve the invoice
            if ($invoiceId && !$paymentIntent) {
                try {
                    $invoice = \Stripe\Invoice::retrieve($invoiceId, ['expand' => ['payment_intent']]);
                    
                    // Log invoice details for debugging
                    Log::info('Retrieved invoice', [
                        'invoice_id' => $invoice->id,
                        'invoice_status' => $invoice->status ?? 'unknown',
                        'has_payment_intent' => isset($invoice->payment_intent),
                        'payment_intent_type' => isset($invoice->payment_intent) ? gettype($invoice->payment_intent) : 'N/A',
                        'collection_method' => $invoice->collection_method ?? 'N/A',
                    ]);
                    
                    if (isset($invoice->payment_intent)) {
                        if (is_object($invoice->payment_intent)) {
                            $paymentIntent = $invoice->payment_intent;
                        } elseif (is_string($invoice->payment_intent)) {
                            $paymentIntent = \Stripe\PaymentIntent::retrieve($invoice->payment_intent);
                        }
                    } else {
                        // Invoice exists but no payment intent
                        // For subscriptions with default_incomplete, the invoice should have a payment intent
                        // If it doesn't, we might need to finalize it or the collection method might be wrong
                        if ($invoice->status === 'draft') {
                            // Finalize the invoice - this should create a payment intent
                            $invoice->finalizeInvoice();
                            // Retrieve again to get payment intent
                            $invoice = \Stripe\Invoice::retrieve($invoiceId, ['expand' => ['payment_intent']]);
                            if (isset($invoice->payment_intent)) {
                                if (is_object($invoice->payment_intent)) {
                                    $paymentIntent = $invoice->payment_intent;
                                } elseif (is_string($invoice->payment_intent)) {
                                    $paymentIntent = \Stripe\PaymentIntent::retrieve($invoice->payment_intent);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to retrieve invoice', [
                        'invoice_id' => $invoiceId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            // Log for debugging
            Log::info('Subscription created', [
                'subscription_id' => $subscription->id,
                'subscription_status' => $subscription->status ?? 'unknown',
                'invoice_id' => $invoiceId,
                'has_payment_intent' => $paymentIntent !== null,
                'payment_intent_id' => $paymentIntent->id ?? 'N/A',
                'payment_intent_status' => $paymentIntent->status ?? 'N/A',
            ]);
            
            // If no payment intent, try retrieving subscription again with expansion
            if (!$paymentIntent) {
                try {
                    $subscriptionRetrieved = Subscription::retrieve($subscription->id, [
                        'expand' => ['latest_invoice.payment_intent']
                    ]);
                    
                    if (isset($subscriptionRetrieved->latest_invoice) && is_object($subscriptionRetrieved->latest_invoice)) {
                        if (isset($subscriptionRetrieved->latest_invoice->payment_intent)) {
                            if (is_object($subscriptionRetrieved->latest_invoice->payment_intent)) {
                                $paymentIntent = $subscriptionRetrieved->latest_invoice->payment_intent;
                            } elseif (is_string($subscriptionRetrieved->latest_invoice->payment_intent)) {
                                $paymentIntent = \Stripe\PaymentIntent::retrieve($subscriptionRetrieved->latest_invoice->payment_intent);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to retrieve subscription with expansion', [
                        'subscription_id' => $subscription->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            // If still no payment intent, create one manually for the invoice
            // This is necessary when default_incomplete doesn't create one automatically
            if (!$paymentIntent && $invoiceId) {
                try {
                    $invoice = \Stripe\Invoice::retrieve($invoiceId);
                    
                    Log::info('No payment intent found, creating one manually', [
                        'invoice_id' => $invoiceId,
                        'invoice_status' => $invoice->status,
                        'invoice_amount_due' => $invoice->amount_due,
                        'invoice_currency' => $invoice->currency,
                    ]);
                    
                    // Create a payment intent for this invoice amount
                    // Use 'automatic' confirmation_method so it can be confirmed client-side
                    // Link it to the invoice so it can be used to pay the invoice
                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $invoice->amount_due,
                        'currency' => $invoice->currency,
                        'customer' => $customerId,
                        'payment_method' => $paymentMethodId,
                        'confirmation_method' => 'automatic',
                        'confirm' => false,
                        'on_behalf_of' => null, // Not needed for subscriptions
                        'metadata' => [
                            'invoice_id' => $invoiceId,
                            'subscription_id' => $subscription->id,
                            'website_id' => $website->id,
                            'plan' => $plan,
                        ],
                    ]);
                    
                    Log::info('Created payment intent manually', [
                        'payment_intent_id' => $paymentIntent->id,
                        'payment_intent_status' => $paymentIntent->status,
                        'invoice_id' => $invoiceId,
                    ]);
                    
                    // Try to update the invoice to use this payment intent
                    // This links the payment intent to the invoice
                    try {
                        \Stripe\Invoice::update($invoiceId, [
                            'payment_intent' => $paymentIntent->id,
                        ]);
                        Log::info('Linked payment intent to invoice', [
                            'payment_intent_id' => $paymentIntent->id,
                            'invoice_id' => $invoiceId,
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Could not link payment intent to invoice (may already have one)', [
                            'payment_intent_id' => $paymentIntent->id,
                            'invoice_id' => $invoiceId,
                            'error' => $e->getMessage(),
                        ]);
                        // Continue - we'll pay the invoice with the payment intent in the confirm endpoint
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to create payment intent manually', [
                        'invoice_id' => $invoiceId,
                        'error' => $e->getMessage(),
                        'error_class' => get_class($e),
                    ]);
                }
            }
            
            // Update payment intent with the payment method if it doesn't already have one
            if ($paymentIntent) {
                try {
                    // Only update if payment method is not already set
                    if (!isset($paymentIntent->payment_method) || $paymentIntent->payment_method !== $paymentMethodId) {
                        \Stripe\PaymentIntent::update($paymentIntent->id, [
                            'payment_method' => $paymentMethodId,
                        ]);
                        // Retrieve updated payment intent to get fresh client_secret
                        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntent->id);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to update payment intent with payment method', [
                        'payment_intent_id' => $paymentIntent->id ?? 'N/A',
                        'error' => $e->getMessage(),
                    ]);
                    // Continue anyway - the client can still confirm with the payment method
                }
            }
            
            // If still no payment intent, something went wrong
            if (!$paymentIntent) {
                Log::error('No payment intent found for subscription after all attempts', [
                    'subscription_id' => $subscription->id,
                    'subscription_status' => $subscription->status ?? 'unknown',
                    'invoice_id' => $invoiceId,
                    'customer_id' => $customerId,
                    'latest_invoice_type' => gettype($subscription->latest_invoice ?? null),
                ]);
                return response()->json([
                    'error' => 'Payment intent not found. Please try again.',
                ], 400);
            }

            // Check payment intent status
            $paymentIntentStatus = $paymentIntent->status ?? null;
            
            // If payment intent requires action (3D Secure), return client secret for client-side confirmation
            if ($paymentIntentStatus === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'client_secret' => $paymentIntent->client_secret,
                    'subscription_id' => $subscription->id,
                ]);
            }

            // If payment intent requires payment method, payment was declined
            if ($paymentIntentStatus === 'requires_payment_method') {
                return response()->json([
                    'error' => 'Payment method was declined. Please try a different payment method.',
                ], 400);
            }

            // If payment intent is processing or succeeded, we still need client-side confirmation
            // for incomplete subscriptions. Return the client secret so client can confirm.
            if (in_array($paymentIntentStatus, ['processing', 'succeeded'])) {
                // Payment might be processing or already succeeded, but subscription is still incomplete
                // Return client secret for confirmation to ensure subscription becomes active
                return response()->json([
                    'requires_action' => false,
                    'client_secret' => $paymentIntent->client_secret,
                    'subscription_id' => $subscription->id,
                ]);
            }

            // For any other status, return client secret for confirmation
            return response()->json([
                'requires_action' => $paymentIntentStatus === 'requires_action',
                'client_secret' => $paymentIntent->client_secret,
                'subscription_id' => $subscription->id,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription creation failed', [
                'website_id' => $website->id,
                'plan' => $plan,
                'price_id' => $priceId,
                'error' => $e->getMessage(),
            ]);

            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, 'No such price')) {
                $errorMessage = 'Invalid Stripe Price ID configured. Please check your .env file. Price IDs must start with "price_" not "prod_".';
            }

            // Always return JSON for API endpoint
            return response()->json(['error' => $errorMessage], 400);
        } catch (\Exception $e) {
            Log::error('Unexpected error creating subscription', [
                'website_id' => $website->id,
                'plan' => $plan,
                'error' => $e->getMessage(),
            ]);

            // Always return JSON for API endpoint
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Confirm payment intent after 3D Secure authentication.
     */
    public function confirm(Website $website, Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Manually validate
        $paymentIntentId = $request->input('payment_intent_id');
        $subscriptionId = $request->input('subscription_id');
        
        if (!$paymentIntentId) {
            return response()->json(['error' => 'Payment intent ID is required'], 422);
        }

        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            
            // Get subscription ID from request or from payment intent metadata/invoice
            if (!$subscriptionId) {
                // Check metadata first (for manually created payment intents)
                if (isset($paymentIntent->metadata->subscription_id)) {
                    $subscriptionId = $paymentIntent->metadata->subscription_id;
                } elseif (isset($paymentIntent->invoice)) {
                    // Try to get from invoice
                    try {
                        $invoice = \Stripe\Invoice::retrieve($paymentIntent->invoice, ['expand' => ['subscription']]);
                        $subscriptionId = $invoice->subscription;
                    } catch (\Exception $e) {
                        Log::warning('Could not retrieve invoice from payment intent', [
                            'invoice_id' => $paymentIntent->invoice,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }
            
            if (!$subscriptionId) {
                return response()->json(['error' => 'Subscription ID not found'], 400);
            }
            
            // Retrieve the subscription to get updated status
            $subscription = Subscription::retrieve($subscriptionId);
            
            // If payment intent succeeded but subscription is still incomplete,
            // we need to pay the invoice with this payment intent
            if ($paymentIntent->status === 'succeeded' && $subscription->status === 'incomplete') {
                try {
                    // Get the invoice ID
                    $invoiceId = is_string($subscription->latest_invoice) 
                        ? $subscription->latest_invoice 
                        : $subscription->latest_invoice->id;
                    
                    $invoice = \Stripe\Invoice::retrieve($invoiceId, ['expand' => ['payment_intent']]);
                    
                    Log::info('Paying invoice with confirmed payment intent', [
                        'invoice_id' => $invoiceId,
                        'invoice_status' => $invoice->status,
                        'payment_intent_id' => $paymentIntentId,
                        'payment_intent_status' => $paymentIntent->status,
                        'subscription_status' => $subscription->status,
                        'invoice_has_payment_intent' => isset($invoice->payment_intent),
                    ]);
                    
                    // Pay the invoice using the payment method from the confirmed payment intent
                    // The invoice->pay() method accepts payment_method, not payment_intent
                    try {
                        // Get the payment method from the payment intent
                        $paymentMethodId = $paymentIntent->payment_method;
                        
                        if (!$paymentMethodId) {
                            throw new \Exception('Payment intent does not have a payment method');
                        }
                        
                        Log::info('Paying invoice with payment method from payment intent', [
                            'invoice_id' => $invoiceId,
                            'payment_method_id' => $paymentMethodId,
                            'payment_intent_id' => $paymentIntentId,
                        ]);
                        
                        // Pay the invoice with the payment method
                        $paidInvoice = $invoice->pay([
                            'payment_method' => $paymentMethodId,
                        ]);
                        
                        Log::info('Invoice paid successfully', [
                            'invoice_id' => $invoiceId,
                            'paid_invoice_status' => $paidInvoice->status ?? 'unknown',
                            'paid_invoice_payment_intent' => $paidInvoice->payment_intent ?? 'N/A',
                        ]);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        // Invoice might already be paid or have a different payment intent
                        $errorMessage = $e->getMessage();
                        Log::warning('Invoice payment error', [
                            'invoice_id' => $invoiceId,
                            'error' => $errorMessage,
                            'error_code' => $e->getStripeCode() ?? 'N/A',
                        ]);
                        
                        // Check if it's already paid
                        if (str_contains($errorMessage, 'already paid') || 
                            str_contains($errorMessage, 'already finalized') ||
                            str_contains($errorMessage, 'No such invoice')) {
                            Log::info('Invoice already paid or finalized', [
                                'invoice_id' => $invoiceId,
                            ]);
                            // Retrieve invoice to check status
                            $invoice = \Stripe\Invoice::retrieve($invoiceId);
                            if ($invoice->status === 'paid') {
                                Log::info('Invoice is already paid', [
                                    'invoice_id' => $invoiceId,
                                ]);
                            }
                        } else {
                            // Re-throw if it's a different error
                            throw $e;
                        }
                    }
                    
                    // Retrieve subscription again to check if it's now active
                    $subscription = Subscription::retrieve($subscriptionId);
                    
                    Log::info('Subscription status after invoice payment', [
                        'subscription_id' => $subscriptionId,
                        'subscription_status' => $subscription->status,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to pay invoice with payment intent', [
                        'invoice_id' => is_string($subscription->latest_invoice) ? $subscription->latest_invoice : ($subscription->latest_invoice->id ?? 'N/A'),
                        'payment_intent_id' => $paymentIntentId,
                        'error' => $e->getMessage(),
                        'error_class' => get_class($e),
                    ]);
                }
            }
            
            // Check if payment succeeded or subscription is active
            if ($paymentIntent->status === 'succeeded' || $subscription->status === 'active') {
                $plan = $subscription->metadata->plan ?? 'basic';
                
                // Update website with subscription info
                $this->updateWebsiteSubscription($website, $subscription, $subscription->customer, $plan);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Subscription created successfully!',
                ]);
            }
            
            // If payment is still processing, that's okay - subscription might become active soon
            if ($paymentIntent->status === 'processing') {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment is processing. Subscription will be activated shortly.',
                ]);
            }

            return response()->json([
                'error' => 'Payment not completed. Status: ' . $paymentIntent->status
            ], 400);
        } catch (ApiErrorException $e) {
            Log::error('Payment confirmation failed', [
                'website_id' => $website->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Helper method to update website subscription data.
     */
    private function updateWebsiteSubscription(Website $website, Subscription $subscription, string $customerId, string $plan): void
    {
        $website->update([
            'plan' => $plan,
            'stripe_id' => $customerId,
            'stripe_subscription_id' => $subscription->id,
            'stripe_price_id' => $subscription->items->data[0]->price->id,
            'stripe_status' => $subscription->status,
            'stripe_trial_ends_at' => $subscription->trial_end ? 
                \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : null,
            'stripe_ends_at' => null,
            'subscription_ends_at' => $subscription->current_period_end ? 
                \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
        ]);
    }


    /**
     * Cancel the current subscription.
     */
    public function cancel(Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to cancel this subscription.');
        }

        if (!$website->stripe_subscription_id) {
            return redirect()->route('admin.websites.show', $website)
                ->with('error', 'No active subscription found.');
        }

        try {
            $subscription = Subscription::retrieve($website->stripe_subscription_id);
            
            // Cancel at period end (don't cancel immediately)
            $subscription->cancel_at_period_end = true;
            $subscription->save();

            $periodEnd = $subscription->current_period_end
                ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)
                : null;
            $website->update([
                'stripe_status' => 'canceled',
                'stripe_ends_at' => $periodEnd,
                'subscription_ends_at' => $periodEnd,
            ]);
            // Plan stays as current until period ends; sync() or __website-status will set plan to 'none' when it has ended

            return redirect()->route('admin.websites.show', $website)
                ->with('success', 'Subscription will be canceled at the end of the billing period.');
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription Cancelation failed', [
                'website_id' => $website->id,
                'subscription_id' => $website->stripe_subscription_id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.websites.show', $website)
                ->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Resume a Canceled subscription.
     */
    public function resume(Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to resume this subscription.');
        }

        if (!$website->stripe_subscription_id) {
            return redirect()->route('admin.websites.show', $website)
                ->with('error', 'No subscription found.');
        }

        try {
            $subscription = Subscription::retrieve($website->stripe_subscription_id);
            
            // Remove Cancelation
            $subscription->cancel_at_period_end = false;
            $subscription->save();

            $website->update([
                'stripe_status' => $subscription->status,
                'stripe_ends_at' => null,
            ]);

            return redirect()->route('admin.websites.show', $website)
                ->with('success', 'Subscription resumed successfully.');
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription resume failed', [
                'website_id' => $website->id,
                'subscription_id' => $website->stripe_subscription_id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.websites.show', $website)
                ->with('error', 'Failed to resume subscription: ' . $e->getMessage());
        }
    }

    /**
     * Sync subscription status from Stripe.
     */
    public function sync(Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to sync this subscription.');
        }

        if (!$website->stripe_subscription_id) {
            return $this->syncRedirect($user, $website)
                ->with('error', 'No subscription found.');
        }

        $redirect = fn () => $this->syncRedirect($user, $website);

        try {
            $subscription = Subscription::retrieve($website->stripe_subscription_id);
            
            $website->update([
                'stripe_status' => $subscription->status,
                'stripe_price_id' => $subscription->items->data[0]->price->id,
                'stripe_trial_ends_at' => $subscription->trial_end ? 
                    \Carbon\Carbon::createFromTimestamp($subscription->trial_end) : null,
                'stripe_ends_at' => $subscription->cancel_at ? 
                    \Carbon\Carbon::createFromTimestamp($subscription->cancel_at) : null,
                'subscription_ends_at' => $subscription->current_period_end ? 
                    \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) : null,
            ]);

            // When subscription has ended, set plan to 'none'
            $website->refresh();
            if (!$website->hasCurrentSubscription()) {
                $website->update(['plan' => 'none']);
            }

            return $redirect()->with('success', 'Subscription status synced successfully.');
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription sync failed', [
                'website_id' => $website->id,
                'subscription_id' => $website->stripe_subscription_id,
                'error' => $e->getMessage(),
            ]);

            // If subscription was deleted in Stripe, clear local subscription data and set plan to 'none'
            if (str_contains($e->getMessage(), 'No such subscription')) {
                $website->update([
                    'plan' => 'none',
                    'stripe_subscription_id' => null,
                    'stripe_price_id' => null,
                    'stripe_status' => null,
                    'stripe_ends_at' => null,
                    'subscription_ends_at' => null,
                ]);
                return $redirect()->with('success', 'Subscription was removed in Stripe. Local data has been cleared.');
            }

            return $redirect()->with('error', 'Failed to sync subscription: ' . $e->getMessage());
        }
    }

    /**
     * Redirect after sync: super-admins go to super-admin show, others to admin show.
     */
    private function syncRedirect(\App\Models\User $user, Website $website): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.websites.show', $website->id);
        }
        return redirect()->route('admin.websites.show', $website);
    }
}
