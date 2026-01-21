<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && true) }" x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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

        @php
            $website = \App\Helpers\WebsiteHelper::current();
            // Get published pages for the current website to display in navigation
            $pages = $website ? \App\Models\Page::where('website_id', $website->id)
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get() : collect();
        @endphp

        <title>{{ $website ? $website->name . ' - ' : '' }}{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900">
        <div class="min-h-screen">
            <!-- Simple Navigation -->
            @if($website)
                <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <div class="flex items-center">
                                <a href="{{ route('website.home') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $website->name }}
                                </a>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('website.home') }}" 
                                   class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.home') ? 'text-purple-600 dark:text-purple-400 font-semibold' : '' }}">
                                    Home
                                </a>
                                <a href="{{ route('website.menu') }}" 
                                   class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.menu') ? 'text-purple-600 dark:text-purple-400 font-semibold' : '' }}">
                                    Menu
                                </a>
                                @foreach($pages as $page)
                                    <a href="{{ route('website.page', $page->slug) }}" 
                                       class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.page') && request()->route('slug') == $page->slug ? 'text-purple-600 dark:text-purple-400 font-semibold' : '' }}">
                                        {{ $page->title }}
                                    </a>
                                @endforeach
                                @auth
                                    @php
                                        $currentWebsite = \App\Helpers\WebsiteHelper::current();
                                    @endphp
                                    @if($currentWebsite)
                                        <a href="{{ route('admin.websites.show', $currentWebsite) }}" 
                                           class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition">
                                            Admin
                                        </a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition">
                                            Admin
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
