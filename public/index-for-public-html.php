<?php

/**
 * Use this file when your host does not allow changing the document root.
 * 1. Upload your full Laravel app to a subfolder, e.g. public_html/stackifide/
 * 2. Copy this file to public_html/index.php (and copy public/.htaccess to public_html/)
 * 3. Copy everything else from public/ (build/, robots.txt, etc.) into public_html/
 * 4. Set the subfolder name below to match where you put the Laravel app.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Folder name where the full Laravel app lives (same level as public_html, or inside it)
$laravelDir = 'stackifide';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/'.$laravelDir.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/'.$laravelDir.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/'.$laravelDir.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
