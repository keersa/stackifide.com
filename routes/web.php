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
$host = $_SERVER['HTTP_HOST'] ?? '';
$isSubdomain = false;

if (str_contains($host, '.localhost') || str_contains($host, '.127.0.0.1')) {
    $isSubdomain = true;
} elseif (str_contains($host, '.')) {
    $hostPart = explode(':', $host)[0];
    $parts = explode('.', $hostPart);
    $isSubdomain = count($parts) >= 3 || (count($parts) === 2 && !in_array($parts[0], ['www', 'localhost', '127']));
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
        Route::get('/upgrades', [PublicPagesController::class, 'upgrades'])->name('upgrades');

        Route::get('/basic/get-started', [BasicController::class, 'survey'])->name('basic.get-started');
        Route::post('/basic/get-started', [BasicController::class, 'store'])->name('basic.store');
        Route::get('/basic/learn-more', [BasicController::class, 'learn'])->name('basic.learn-more');

        Route::get('/pro/get-started', [ProController::class, 'survey'])->name('pro.get-started');
        Route::post('/pro/get-started', [ProController::class, 'store'])->name('pro.store');
        Route::get('/pro/learn-more', [ProController::class, 'learn'])->name('pro.learn-more');

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
            Route::get('/account', [\App\Http\Controllers\Admin\AccountController::class, 'edit'])->name('account');
            Route::patch('/account', [\App\Http\Controllers\Admin\AccountController::class, 'update'])->name('account.update');
            Route::delete('/account', [\App\Http\Controllers\Admin\AccountController::class, 'destroy'])->name('account.destroy');
            Route::resource('websites', \App\Http\Controllers\Admin\WebsiteController::class);

            // Admin can manage any website's content by specifying website
            Route::prefix('websites/{website}')->name('websites.')->group(function () {
                // Website Images
                Route::get('images', [\App\Http\Controllers\Website\WebsiteImageController::class, 'index'])->name('images.index');
                Route::post('images/upload-logo', [\App\Http\Controllers\Website\WebsiteImageController::class, 'uploadLogo'])->name('images.upload-logo');
                Route::post('images/set-preferred-logo', [\App\Http\Controllers\Website\WebsiteImageController::class, 'setPreferredType'])->name('images.set-preferred-logo');
                Route::delete('images/remove-logo', [\App\Http\Controllers\Website\WebsiteImageController::class, 'removeLogo'])->name('images.remove-logo');

                // Store Hours (per-website weekly hours)
                Route::get('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'index'])->name('hours.index');
                Route::get('hours/create', [\App\Http\Controllers\Website\StoreHoursController::class, 'create'])->name('hours.create');
                Route::post('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'store'])->name('hours.store');
                Route::get('hours/edit', [\App\Http\Controllers\Website\StoreHoursController::class, 'edit'])->name('hours.edit');
                Route::put('hours', [\App\Http\Controllers\Website\StoreHoursController::class, 'update'])->name('hours.update');

                // Subscription management
                Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
                    Route::get('create', [\App\Http\Controllers\Admin\SubscriptionController::class, 'create'])->name('create');
                    Route::post('store', [\App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('store');
                    Route::post('confirm', [\App\Http\Controllers\Admin\SubscriptionController::class, 'confirm'])->name('confirm');
                    Route::post('upgrade', [\App\Http\Controllers\Admin\SubscriptionController::class, 'upgrade'])->name('upgrade');
                    Route::post('cancel', [\App\Http\Controllers\Admin\SubscriptionController::class, 'cancel'])->name('cancel');
                    Route::post('resume', [\App\Http\Controllers\Admin\SubscriptionController::class, 'resume'])->name('resume');
                    Route::post('sync', [\App\Http\Controllers\Admin\SubscriptionController::class, 'sync'])->name('sync');
                });
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
