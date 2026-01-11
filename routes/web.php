<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::get('/basic/get-started', [BasicController::class, 'survey'])->name('basic.get-started');
    Route::post('/basic/get-started', [BasicController::class, 'store'])->name('basic.store');
    Route::get('/basic/learn-more', [BasicController::class, 'learn'])->name('basic.learn-more');
    Route::get('/pro/get-started', [ProController::class, 'survey'])->name('pro.get-started');
    Route::get('/pro/learn-more', [ProController::class, 'learn'])->name('pro.learn-more');
    Route::get('/partner/get-started', [PartnerController::class, 'survey'])->name('partner.get-started');
    Route::get('/partner/learn-more', [PartnerController::class, 'learn'])->name('partner.learn-more');
    Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('websites', [WebsiteController::class, 'index'])->name('websites.index');
    Route::get('websites/{website}', [WebsiteController::class, 'show'])->name('websites.show');
    Route::get('websites/{website}/edit', [WebsiteController::class, 'edit'])->name('websites.edit');
    Route::put('websites/{website}', [WebsiteController::class, 'update'])->name('websites.update');
    Route::delete('websites/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class);
});

require __DIR__.'/auth.php';
