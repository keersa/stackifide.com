<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && true) }"
      x-init="$watch('darkMode', value => { localStorage.setItem('darkMode', value); document.documentElement.classList.toggle('dark', value); })"
      x-bind:class="{ 'dark': darkMode }"
      class="scroll-smooth">
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
                                
                                @php
                                    $hoursHref = request()->routeIs('website.home')
                                        ? '#hours'
                                        : route('website.home') . '#hours';
                                @endphp
                                <a href="{{ $hoursHref }}"
                                   class="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 px-3 py-2 rounded-md text-sm font-medium transition">
                                    Hours
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

                                <!-- Dark Mode Toggle -->
                                <button
                                    type="button"
                                    @click="darkMode = !darkMode"
                                    class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors"
                                    aria-label="Toggle dark mode"
                                >
                                    <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                    <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer id="footer" class="py-16 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="">
                        <div class="block p-12 bg-gray-400 dark:bg-gray-600 rounded-lg bg-opacity-50 dark:bg-opacity-50">
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                &copy; {{ date('Y') }} {{ $website->name }}. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
