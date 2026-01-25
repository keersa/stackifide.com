<?php

use App\Http\Controllers\BasicController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPagesController;
use Illuminate\Support\Facades\Route;

// Detect whether current host is a (website) subdomain.
// We use this to avoid registering main-site routes on website subdomains,
// otherwise shared paths like `/about` will match the main-site route first
// and never reach the website catch-all `/{slug}` route.
$hostWithoutPort = null;
if (isset($_SERVER['HTTP_HOST'])) {
    $hostWithoutPort = explode(':', $_SERVER['HTTP_HOST'])[0];
}

$isSubdomain = false;
if ($hostWithoutPort === null) {
    // CLI / tests
    $isSubdomain = false;
} elseif ($hostWithoutPort === 'localhost') {
    $isSubdomain = false;
} elseif (str_ends_with($hostWithoutPort, '.localhost')) {
    $isSubdomain = true;
} elseif (str_contains($hostWithoutPort, '.')) {
    $parts = explode('.', $hostWithoutPort);
    $isSubdomain = count($parts) >= 3 || (count($parts) === 2 && $parts[0] !== 'www' && $parts[0] !== 'localhost');
}

// Main site routes (only register when NOT on a website subdomain)
if (!$isSubdomain) {
    Route::middleware('main-site')->group(function () {
        Route::get('/', function () {return view('welcome'); })->name('welcome');

        Route::get('/about', [PublicPagesController::class, 'about'])->name('about.index');
        Route::get('/contact', [PublicPagesController::class, 'contact'])->name('contact.index');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
        Route::get('/faqs', [PublicPagesController::class, 'faqs'])->name('faqs.index');
        Route::get('/pricing', [PublicPagesController::class, 'pricing'])->name('pricing.index');

        Route::get('/basic/get-started', [BasicController::class, 'survey'])->name('basic.get-started');
        Route::post('/basic/get-started', [BasicController::class, 'store'])->name('basic.store');
        Route::get('/basic/learn-more', [BasicController::class, 'learn'])->name('basic.learn-more');
        Route::get('/pro/get-started', [ProController::class, 'survey'])->name('pro.get-started');
        Route::get('/pro/learn-more', [ProController::class, 'learn'])->name('pro.learn-more');
        Route::get('/partner/get-started', [PartnerController::class, 'survey'])->name('partner.get-started');
        Route::get('/partner/learn-more', [PartnerController::class, 'learn'])->name('partner.learn-more');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Admin routes
        Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
            Route::resource('websites', \App\Http\Controllers\Admin\WebsiteController::class);

            // Admin can manage any website's content by specifying website
            Route::prefix('websites/{website}')->name('websites.')->group(function () {
                Route::resource('menu', \App\Http\Controllers\Website\MenuController::class)
                    ->parameters(['menu' => 'menu'])
                    ->names([
                        'index' => 'menu.index',
                        'create' => 'menu.create',
                        'store' => 'menu.store',
                        'show' => 'menu.show',
                        'edit' => 'menu.edit',
                        'update' => 'menu.update',
                        'destroy' => 'menu.destroy',
                    ]);
                Route::post('menu/upload-image', [\App\Http\Controllers\Website\MenuController::class, 'uploadImage'])
                    ->name('menu.upload-image');
                Route::post('menu/reorder', [\App\Http\Controllers\Website\MenuController::class, 'reorder'])->name('menu.reorder');

                // Store Hours (per-website weekly hours)
                Route::get('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'index'])->name('hours.index');
                Route::get('hours/create', [\App\Http\Controllers\Website\StoreHoursController::class, 'create'])->name('hours.create');
                Route::post('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'store'])->name('hours.store');
                Route::get('hours/edit', [\App\Http\Controllers\Website\StoreHoursController::class, 'edit'])->name('hours.edit');
                Route::put('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'update'])->name('hours.update');

                Route::resource('pages', \App\Http\Controllers\Website\PageController::class)
                    ->parameters(['pages' => 'page'])
                    ->names([
                        'index' => 'pages.index',
                        'create' => 'pages.create',
                        'store' => 'pages.store',
                        'show' => 'pages.show',
                        'edit' => 'pages.edit',
                        'update' => 'pages.update',
                        'destroy' => 'pages.destroy',
                    ]);
                Route::post('pages/reorder', [\App\Http\Controllers\Website\PageController::class, 'reorder'])->name('pages.reorder');
            });
        });

        require __DIR__.'/auth.php';
    });

    // Super Admin routes (only on main site)
    Route::middleware(['auth', 'super_admin', 'main-site'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'index'])->name('dashboard');
        Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class);
        Route::resource('users', \App\Http\Controllers\SuperAdmin\UserController::class);
        Route::get('logs', [\App\Http\Controllers\SuperAdmin\LogController::class, 'index'])->name('logs.index');
        Route::get('websites', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'index'])->name('websites.index');
        Route::get('websites/create', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'create'])->name('websites.create');
        Route::post('websites', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'store'])->name('websites.store');
        Route::get('websites/{id}', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'show'])->name('websites.show');
        Route::get('websites/{id}/edit', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'edit'])->name('websites.edit');
        Route::put('websites/{id}', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'update'])->name('websites.update');
        Route::delete('websites/{id}', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'destroy'])->name('websites.destroy');
        Route::post('websites/{id}/restore', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'restore'])->name('websites.restore');
        Route::delete('websites/{id}/force-delete', [\App\Http\Controllers\SuperAdmin\WebsiteController::class, 'forceDelete'])->name('websites.force-delete');
    });
}

// Website routes (only register on website subdomains)
if ($isSubdomain) {
    require __DIR__.'/website.php';
}