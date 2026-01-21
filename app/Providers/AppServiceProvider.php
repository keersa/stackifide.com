<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Models\Website;
use App\Models\MenuItem;
use App\Models\Page;
use App\Observers\WebsiteObserver;
use App\Observers\PageObserver;
use App\Observers\MenuItemObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // Register model observers for logging
        Website::observe(WebsiteObserver::class);
        Page::observe(PageObserver::class);
        MenuItem::observe(MenuItemObserver::class);

        // Configure route model binding for website parameter
        Route::bind('website', function ($value) {
            return Website::where('id', $value)
                ->orWhere('slug', $value)
                ->firstOrFail();
        });

        // Configure route model binding for menu parameter (MenuItem)
        // Scope to the website if available in the route
        Route::bind('menu', function ($value) {
            // Try to get website ID from route segments (more reliable than parameter)
            $segments = request()->segments();
            $websiteIndex = array_search('websites', $segments);
            
            if ($websiteIndex !== false && isset($segments[$websiteIndex + 1])) {
                $websiteIdOrSlug = $segments[$websiteIndex + 1];
                // Resolve website ID
                $website = Website::where('id', $websiteIdOrSlug)
                    ->orWhere('slug', $websiteIdOrSlug)
                    ->first();
                
                if ($website) {
                    return MenuItem::where('id', $value)
                        ->where('website_id', $website->id)
                        ->firstOrFail();
                }
            }
            
            // Fallback: just find the menu item by ID
            return MenuItem::findOrFail($value);
        });

        // Configure route model binding for page parameter
        // Note: We use 'page' (singular) because of ->parameters(['pages' => 'page'])
        Route::bind('page', function ($value) {
            // Ensure we're getting a Page model, not accidentally a Website
            // Try to get website ID from route segments
            $segments = request()->segments();
            $websiteIndex = array_search('websites', $segments);
            
            if ($websiteIndex !== false && isset($segments[$websiteIndex + 1])) {
                $websiteIdOrSlug = $segments[$websiteIndex + 1];
                // Resolve website ID
                $website = Website::where('id', $websiteIdOrSlug)
                    ->orWhere('slug', $websiteIdOrSlug)
                    ->first();
                
                if ($website) {
                    $page = Page::where('id', $value)
                        ->where('website_id', $website->id)
                        ->firstOrFail();
                    
                    // Double-check we have a Page model
                    if (!$page instanceof Page) {
                        abort(404);
                    }
                    
                    return $page;
                }
            }
            
            // Fallback: just find the page by ID
            $page = Page::findOrFail($value);
            
            // Double-check we have a Page model
            if (!$page instanceof Page) {
                abort(404);
            }
            
            return $page;
        });
    }
}
