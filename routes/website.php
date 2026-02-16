<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Routes (Public-facing restaurant websites)
|--------------------------------------------------------------------------
|
| These routes are only accessible when a website is identified.
| Routes are conditionally loaded based on host/subdomain detection.
|
*/

// Always register website routes - middleware will handle access control
// The IdentifyWebsite middleware (applied globally) will identify the website
// The EnsureWebsiteSite middleware will ensure we're on a website site
// Routes are loaded last in web.php so main site routes match first
// Use where() constraint to only match on website subdomains
Route::middleware('website-site')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Website status check (fresh from DB - used by inactive modal)
    |--------------------------------------------------------------------------
    */
    Route::get('/__website-status', function () {
        $website = \App\Helpers\WebsiteHelper::current();
        if (!$website) {
            return response()->json(['active' => false]);
        }
        // Re-load from DB and optionally sync subscription from Stripe for accurate status
        $website->refresh();
        if ($website->stripe_subscription_id && config('services.stripe.secret')) {
            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                $subscription = \Stripe\Subscription::retrieve($website->stripe_subscription_id);
                $website->update([
                    'stripe_status' => $subscription->status,
                    'stripe_ends_at' => $subscription->cancel_at
                        ? \Carbon\Carbon::createFromTimestamp($subscription->cancel_at)
                        : null,
                    'subscription_ends_at' => $subscription->current_period_end
                        ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)
                        : null,
                ]);
                $website->refresh();
                // When subscription has ended, set plan to 'none'
                if (!$website->isActive()) {
                    $website->update(['plan' => 'none']);
                }
            } catch (\Exception $e) {
                // If subscription was deleted in Stripe, set plan to 'none'
                if (str_contains($e->getMessage(), 'No such subscription')) {
                    $website->update([
                        'plan' => 'none',
                        'stripe_subscription_id' => null,
                        'stripe_price_id' => null,
                        'stripe_status' => null,
                        'stripe_ends_at' => null,
                        'subscription_ends_at' => null,
                    ]);
                }
            }
        }
        return response()->json(['active' => $website->isActive()]);
    })->name('website.status');

    /*
    |--------------------------------------------------------------------------
    | Public Website Routes (Customer-facing)
    |--------------------------------------------------------------------------
    |
    | These routes are accessible to visitors on website domains.
    | All editing is done through the /admin section.
    |
    */
    Route::get('/', function () {
        $website = \App\Helpers\WebsiteHelper::current();
        if (!$website) {
            abort(404);
        }
        $theme = in_array($website->theme ?? 'default', ['default', 'advanced']) ? $website->theme : 'default';
        return view("website.{$theme}.home", compact('website'));
    })->name('website.home');

}); // End website site check middleware
