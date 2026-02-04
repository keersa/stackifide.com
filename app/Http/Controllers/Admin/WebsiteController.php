<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Subscription;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Website::with('user')->latest();

        // Only show websites created by the current user
        $user = Auth::user();
        $query->where('user_id', $user->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('domain', 'like', "%{$search}%")
                    ->orWhere('subdomain', 'like', "%{$search}%");
            });
        }

        $websites = $query->paginate(20);

        return view('admin.websites.index', [
            'websites' => $websites,
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['none', 'basic', 'pro', 'enterprise'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.websites.create', [
            'statuses' => ['active', 'suspended', 'pending', 'trial'],
            'plans' => ['none', 'basic', 'pro', 'enterprise'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Convert empty strings to null for nullable fields
        $request->merge([
            'domain' => $request->input('domain') ?: null,
            'subdomain' => $request->input('subdomain') ?: null,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('websites', 'slug')],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'domain')],
            'subdomain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'subdomain')],
            'status' => ['required', 'in:active,suspended,pending,trial'],
            'description' => ['nullable', 'string'],
            'timezone' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && !in_array($value, \DateTimeZone::listIdentifiers(), true)) {
                        $fail('The selected timezone is invalid.');
                    }
                },
            ],
        ]);

        // Create the website and tie it to the current user (admin/super_admin)
        $website = Website::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'domain' => $validated['domain'] ?? null,
            'subdomain' => $validated['subdomain'] ?? null,
            'status' => $validated['status'],
            'plan' => $validated['plan'],
            'description' => $validated['description'] ?? null,
            'timezone' => $validated['timezone'] ?? null,
        ]);

        return redirect()->route('admin.websites.index')
            ->with('success', 'Website created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website): View
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this website.');
        }
        
        $website->load('user');

        // When subscription is Canceled but we don't have an expiration date, fetch from Stripe so the date can be shown
        if ($website->hasCanceledSubscriptionStatus() && !$website->getSubscriptionExpirationDate() && $website->stripe_subscription_id && config('services.stripe.secret')) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $subscription = Subscription::retrieve($website->stripe_subscription_id);
                $endTimestamp = $subscription->cancel_at ?? $subscription->current_period_end ?? null;
                $periodEnd = $endTimestamp ? \Carbon\Carbon::createFromTimestamp($endTimestamp) : null;
                if ($periodEnd) {
                    $website->update([
                        'stripe_ends_at' => $periodEnd,
                        'subscription_ends_at' => $periodEnd,
                    ]);
                    $website->refresh();
                }
            } catch (\Exception $e) {
                // Ignore Stripe errors; page will show Canceled without date
            }
        }

        $current_active_uri = '';
        if(config('app.env') === 'production') {
            $current_active_uri = 'https://' . ($website->domain ?? $website->subdomain) . '.' . config('app.domain');
        } else {
            $current_active_uri = 'http://' . ($website->domain ?? $website->subdomain) . '.' . config('app.domain');
        }
        return view('admin.websites.show', compact('website', 'current_active_uri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website): View
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to edit this website.');
        }
        
        $website->load('user');
        return view('admin.websites.edit', [
            'website' => $website,
            'countries' => config('countries.list', ['United States']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to update this website.');
        }
        
        // Convert empty strings to null for nullable fields
        $socialLinksInput = collect($request->input('social_links', []))->map(function ($value) {
            return is_string($value) && trim($value) === '' ? null : $value;
        })->all();
        $request->merge([
            'domain' => $request->input('domain') ?: null,
            'subdomain' => $request->input('subdomain') ?: null,
            'social_links' => $socialLinksInput,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('websites', 'slug')->ignore($website->id)],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'domain')->ignore($website->id)],
            'subdomain' => ['nullable', 'string', 'max:255', Rule::unique('websites', 'subdomain')->ignore($website->id)],
            'description' => ['nullable', 'string'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'timezone' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && !in_array($value, \DateTimeZone::listIdentifiers(), true)) {
                        $fail('The selected timezone is invalid.');
                    }
                },
            ],
            'contact_info' => ['nullable', 'array'],
            'contact_info.phone' => ['nullable', 'string', 'max:50'],
            'contact_info.email' => ['nullable', 'string', 'email', 'max:255'],
            'contact_info.street_address' => ['nullable', 'string', 'max:255'],
            'contact_info.suite' => ['nullable', 'string', 'max:100'],
            'contact_info.city' => ['nullable', 'string', 'max:100'],
            'contact_info.state' => ['nullable', 'string', 'max:100'],
            'contact_info.zipcode' => ['nullable', 'string', 'max:20'],
            'contact_info.country' => ['nullable', 'string', 'max:100'],
            'social_links' => ['nullable', 'array'],
            'social_links.facebook' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.instagram' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.twitter' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.youtube' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.tiktok' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.linkedin' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.yelp' => ['nullable', 'string', 'max:500', 'url'],
            'social_links.tripadvisor' => ['nullable', 'string', 'max:500', 'url'],
        ]);

        $main = collect($validated)->except(['contact_info', 'social_links'])->all();
        $contactInfo = array_merge($website->contact_info ?? [], $validated['contact_info'] ?? []);
        $socialLinks = $website->social_links ?? [];
        foreach ($validated['social_links'] ?? [] as $key => $value) {
            $value = is_string($value) ? trim($value) : $value;
            if ($value === '') {
                unset($socialLinks[$key]);
            } else {
                $socialLinks[$key] = $value;
            }
        }
        $website->update($main + ['contact_info' => $contactInfo, 'social_links' => $socialLinks]);

        return redirect()->route('admin.websites.show', $website)
            ->with('success', 'Website updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if user owns this website or is super admin
        if (!$user->isSuperAdmin() && $website->user_id !== $user->id) {
            abort(403, 'You do not have permission to delete this website.');
        }
        
        $website->delete();

        return redirect()->route('admin.websites.index')
            ->with('success', 'Website deleted successfully.');
    }
}
