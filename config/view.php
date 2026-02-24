<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | We use storage_path() without realpath() so the path is always a string.
    | The directory is created if missing so shared hosting without artisan works.
    |
    */

    'compiled' => (function () {
        $path = env('VIEW_COMPILED_PATH') ?: storage_path('framework/views');
        if (empty($path) || ! is_string($path)) {
            return sys_get_temp_dir();
        }
        if (! is_dir($path)) {
            @mkdir($path, 0755, true);
        }
        // If still not a directory (e.g. mkdir failed on shared hosting), use temp dir
        return is_dir($path) ? $path : sys_get_temp_dir();
    })(),

];
