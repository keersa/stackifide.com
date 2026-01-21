<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'super_admin' => \App\Http\Middleware\EnsureSuperAdmin::class,
            'website' => \App\Http\Middleware\IdentifyWebsite::class,
            'main-site' => \App\Http\Middleware\EnsureMainSite::class,
            'website-site' => \App\Http\Middleware\EnsureWebsiteSite::class,
            'website.owner_or_admin' => \App\Http\Middleware\EnsureWebsiteOwnerOrAdmin::class,
        ]);
        
        // Apply website identification globally
        $middleware->web(append: [
            \App\Http\Middleware\IdentifyWebsite::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
