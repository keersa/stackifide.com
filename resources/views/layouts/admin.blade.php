<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && true) }" x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-CHRWQ8QHS2"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-CHRWQ8QHS2');
        </script>

        <script>
            // Prevent flash of light mode - runs immediately before page render
            (function() {
                const darkMode = localStorage.getItem('darkMode') === 'true' || 
                    (!localStorage.getItem('darkMode') && true);
                if (darkMode) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gradient-to-r md:dark:bg-gradient-to-br dark:from-gray-900 dark:via-lime-600 dark:to-gray-900">
        <div class="min-h-screen bg-gray-100 dark:bg-transparent">
            @include('layouts.admin-navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 dark:bg-opacity-50 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

