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
            $theme = $website && in_array($website->theme ?? 'default', ['default', 'advanced']) ? $website->theme : 'default';
            $pages = $website ? \App\Models\Page::where('website_id', $website->id)
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get() : collect();
            $hasHours = $website && \App\Models\StoreHour::where('website_id', $website->id)->exists();
            $isInactive = $website && !$website->isActive();
            $accentHover = $theme === 'advanced' ? 'hover:text-amber-600 dark:hover:text-amber-400' : 'hover:text-cyan-600 dark:hover:text-cyan-400';
            $accentActive = $theme === 'advanced' ? 'text-amber-600 dark:text-amber-400' : 'text-cyan-600 dark:text-cyan-400';
        @endphp

        <title>{{ $website ? $website->name . ' - ' : '' }}{{ $website->tagline ? $website->tagline : '' }}</title>

        <!-- Favicon -->
        @if($website->logo_url)
            <link rel="icon" type="image/png" href="{{ $website->logo_url }}">
            <link rel="shortcut icon" type="image/png" href="{{ $website->logo_url }}">
        @else
            <link rel="icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">
            <link rel="shortcut icon" type="image/png" href="{{ asset('images/stackifide-logo.png') }}">
        @endif
        

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @if($website && ($website->theme ?? 'default') === 'advanced')
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
        @endif

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900">
        <div class="min-h-screen">
            @if($isInactive)
            <!-- Inactive site banner -->
            <div class="bg-amber-500 dark:bg-amber-600 text-amber-950 dark:text-amber-100 text-center py-2 px-4 text-lg font-bold">
                Site Inactive
            </div>
            @endif

            <!-- Responsive Navigation -->
            @if($website)
                <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ mobileMenuOpen: false }">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-24">
                            <div class="flex items-center shrink-0">
                                <a href="{{ route('website.home') }}" class="flex items-center gap-2">
                            

                                    @if($website->logo_rect_url)
                                        <img src="{{ $website->logo_rect_url }}" 
                                             alt="{{ $website->name }} Logo" 
                                             class="max-h-[100px] py-2 w-auto object-contain"
                                        >
                                    @else
                                        <span class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white truncate max-w-[140px] sm:max-w-none">
                                            {{ $website->name }}
                                        </span>
                                    @endif
                                </a>
                            </div>

                            <!-- Right side: desktop nav links + dark mode + mobile menu -->
                            <div class="flex items-center gap-1 lg:gap-2">
                                <!-- Desktop nav links -->
                                <div class="hidden md:flex items-center gap-1 lg:gap-2">
                                    <a href="{{ route('website.home') }}" 
                                   class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.home') ? $accentActive . ' font-semibold' : '' }}">
                                    Home
                                </a>
                                @if($hasHours)
                                    @php
                                        $hoursHref = request()->routeIs('website.home')
                                            ? '#hours'
                                            : route('website.home') . '#hours';
                                    @endphp
                                    <a href="{{ $hoursHref }}"
                                       class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition">
                                        Hours
                                    </a>
                                @endif
                                <a href="{{ route('website.menu') }}" 
                                   class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.menu') ? $accentActive . ' font-semibold' : '' }}">
                                    Menu
                                </a>
                                @foreach($pages as $page)
                                    <a href="{{ route('website.page', $page->slug) }}" 
                                       class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('website.page') && request()->route('slug') == $page->slug ? $accentActive . ' font-semibold' : '' }}">
                                        {{ $page->title }}
                                    </a>
                                @endforeach
                                @auth
                                    @php
                                        $currentWebsite = \App\Helpers\WebsiteHelper::current();
                                    @endphp
                                    @if($currentWebsite)
                                        <a href="{{ route('admin.websites.show', $currentWebsite) }}" 
                                           class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition">
                                            Admin
                                        </a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}" 
                                           class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-3 py-2 rounded-md text-sm font-medium transition">
                                            Admin
                                        </a>
                                    @endif
                                @endauth
                                </div>

                                <!-- Dark mode + mobile menu button -->
                                <div class="flex items-center gap-1">
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
                                <button
                                    type="button"
                                    @click="mobileMenuOpen = !mobileMenuOpen"
                                    class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors"
                                    aria-label="Toggle menu"
                                    aria-expanded="false"
                                    x-bind:aria-expanded="mobileMenuOpen"
                                >
                                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                    <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile menu dropdown -->
                        <div x-show="mobileMenuOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             @click.away="mobileMenuOpen = false"
                             class="md:hidden border-t border-gray-200 dark:border-gray-700 py-3"
                             style="display: none;">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('website.home') }}" 
                                   @click="mobileMenuOpen = false"
                                   class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition {{ request()->routeIs('website.home') ? $accentActive . ' font-semibold bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Home
                                </a>
                                @if($hasHours)
                                    <a href="{{ $hoursHref }}"
                                       @click="mobileMenuOpen = false"
                                       class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition">
                                        Hours
                                    </a>
                                @endif
                                <a href="{{ route('website.menu') }}" 
                                   @click="mobileMenuOpen = false"
                                   class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition {{ request()->routeIs('website.menu') ? $accentActive . ' font-semibold bg-gray-100 dark:bg-gray-700' : '' }}">
                                    Menu
                                </a>
                                @foreach($pages as $page)
                                    <a href="{{ route('website.page', $page->slug) }}" 
                                       @click="mobileMenuOpen = false"
                                       class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition {{ request()->routeIs('website.page') && request()->route('slug') == $page->slug ? $accentActive . ' font-semibold bg-gray-100 dark:bg-gray-700' : '' }}">
                                        {{ $page->title }}
                                    </a>
                                @endforeach
                                @auth
                                    @if($currentWebsite ?? null)
                                        <a href="{{ route('admin.websites.show', $currentWebsite) }}" 
                                           @click="mobileMenuOpen = false"
                                           class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition">
                                            Admin
                                        </a>
                                    @else
                                        <a href="{{ route('admin.dashboard') }}" 
                                           @click="mobileMenuOpen = false"
                                           class="text-gray-700 dark:text-gray-300 {{ $accentHover }} px-4 py-3 rounded-md text-base font-medium transition">
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
            @if($website)
            <footer id="footer" class="py-12 sm:py-16 bg-white dark:bg-gray-800 shadow-sm border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center gap-6">
                        @php
                            $socialLinks = $website->social_links ?? [];
                            $hasSocialLinks = !empty(array_filter($socialLinks));
                        @endphp
                        @if($hasSocialLinks)
                            <div class="flex items-center justify-center gap-3 sm:gap-4 flex-wrap">
                                @foreach(config('social_links.links', []) as $key => $config)
                                    @if(!empty(trim($socialLinks[$key] ?? '')))
                                        <a href="{{ $socialLinks[$key] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="p-2 rounded-lg text-gray-500 dark:text-gray-400 {{ $theme === 'advanced' ? 'hover:text-amber-600 dark:hover:text-amber-400' : 'hover:text-purple-600 dark:hover:text-purple-400' }} hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                           aria-label="{{ $config['label'] }}">
                                            @include('components.icons.social.' . $key)
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 text-sm">
                            <a href="{{ route('website.home') }}" class="text-gray-500 dark:text-gray-400 {{ $theme === 'advanced' ? 'hover:text-amber-600 dark:hover:text-amber-400' : 'hover:text-cyan-600 dark:hover:text-cyan-400' }} transition-colors">Home</a>
                            <a href="{{ route('website.menu') }}" class="text-gray-500 dark:text-gray-400 {{ $theme === 'advanced' ? 'hover:text-amber-600 dark:hover:text-amber-400' : 'hover:text-cyan-600 dark:hover:text-cyan-400' }} transition-colors">Menu</a>
                            @if($hasHours)
                                <a href="{{ route('website.home') }}#hours" class="text-gray-500 dark:text-gray-400 {{ $theme === 'advanced' ? 'hover:text-amber-600 dark:hover:text-amber-400' : 'hover:text-cyan-600 dark:hover:text-cyan-400' }} transition-colors">Hours</a>
                            @endif
                        </div>
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} {{ $website->name }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
            @endif
        </div>
    </body>
</html>
