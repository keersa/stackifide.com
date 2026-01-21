<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Routes (Restaurant Owner Admin Panel)
|--------------------------------------------------------------------------
|
| These routes are only accessible when a website is identified.
| Restaurant owners can manage their content here.
|
*/

// Only register website routes if we're actually on a website site
// Check the host to determine if this might be a website site
// (Routes are loaded before middleware, so we need to check the host directly)
$host = request()->getHost();
$hostWithoutPort = preg_replace('/:\d+$/', '', $host);
$shouldLoadWebsiteRoutes = false;

// Check if this is a localhost subdomain (e.g., restaurant1.localhost)
if (str_ends_with($hostWithoutPort, '.localhost') || str_ends_with($hostWithoutPort, '.127.0.0.1')) {
    $subdomain = str_replace(['.localhost', '.127.0.0.1'], '', $hostWithoutPort);
    
    if ($subdomain && $subdomain !== $hostWithoutPort) {
        // Try to find by subdomain or slug
        $website = \App\Models\Website::where(function($query) use ($subdomain) {
                $query->where('subdomain', $subdomain)
                      ->orWhere('slug', $subdomain);
            })
            ->where('status', 'active')
            ->first();
        
        $shouldLoadWebsiteRoutes = $website !== null;
        
        // Bind it early so middleware doesn't need to look it up again
        if ($shouldLoadWebsiteRoutes) {
            app()->instance('website', $website);
        }
    }
}

// Check for plain localhost with ?website= parameter (for testing)
if (!$shouldLoadWebsiteRoutes && in_array($hostWithoutPort, ['localhost', '127.0.0.1']) && request()->has('website')) {
    $websiteParam = request()->get('website');
    $website = \App\Models\Website::where('slug', $websiteParam)
        ->orWhere('domain', $websiteParam)
        ->orWhere('subdomain', $websiteParam)
        ->where('status', 'active')
        ->first();
    
    $shouldLoadWebsiteRoutes = $website !== null;
    
    if ($shouldLoadWebsiteRoutes) {
        app()->instance('website', $website);
    }
}

// Check for production subdomains
if (!$shouldLoadWebsiteRoutes) {
    $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
    
    if ($host !== $mainDomain && str_ends_with($host, '.' . $mainDomain)) {
        $subdomain = str_replace('.' . $mainDomain, '', $host);
        
        if ($subdomain && $subdomain !== $host) {
            $website = \App\Models\Website::where(function($query) use ($subdomain) {
                    $query->where('subdomain', $subdomain)
                          ->orWhere('slug', $subdomain);
                })
                ->where('status', 'active')
                ->first();
            
            $shouldLoadWebsiteRoutes = $website !== null;
            
            if ($shouldLoadWebsiteRoutes) {
                app()->instance('website', $website);
            }
        }
    }
}

if ($shouldLoadWebsiteRoutes) {
    // Ensure we're on a website site
    Route::middleware('website-site')->group(function () {
        
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
        return view('website.home', compact('website'));
    })->name('website.home');

    Route::get('/menu', function () {
        $website = \App\Helpers\WebsiteHelper::current();
        $menuItems = \App\Models\MenuItem::where('website_id', $website->id)
            ->where('is_available', true)
            ->orderBy('category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
        return view('website.menu', compact('website', 'menuItems'));
    })->name('website.menu');

    Route::get('/{slug}', function ($slug) {
        $website = \App\Helpers\WebsiteHelper::current();
        $page = \App\Models\Page::where('website_id', $website->id)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return view('website.page', compact('website', 'page'));
    })->name('website.page');
    }); // End website site check middleware
} // End website check
