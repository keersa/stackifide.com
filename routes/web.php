<?php

use App\Http\Controllers\BasicController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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
