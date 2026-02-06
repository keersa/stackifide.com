@props(['active' => null])

@php
    $user = auth()->user();
    
    // Get current website from route if available
    $currentWebsite = null;
    
    // First try to get from route parameter (works with route model binding)
    $routeWebsite = request()->route('website');
    if ($routeWebsite) {
        // If it's already a model instance, use it
        if ($routeWebsite instanceof \App\Models\Website) {
            $currentWebsite = $routeWebsite;
        } else {
            // If it's a string (ID or slug), find the model
            $currentWebsite = \App\Models\Website::where('id', $routeWebsite)
                ->orWhere('slug', $routeWebsite)
                ->first();
        }
    } 
    // Fallback: extract from URL segments for website-related routes
    elseif (request()->routeIs('admin.websites.*')) {
        $segments = request()->segments();
        $websiteIndex = array_search('websites', $segments);
        if ($websiteIndex !== false && isset($segments[$websiteIndex + 1])) {
            $websiteIdOrSlug = $segments[$websiteIndex + 1];
            if (is_numeric($websiteIdOrSlug) || !in_array($websiteIdOrSlug, ['create', 'index'])) {
                $currentWebsite = \App\Models\Website::where('id', $websiteIdOrSlug)
                    ->orWhere('slug', $websiteIdOrSlug)
                    ->first();
            }
        }
    }
@endphp

<aside class="w-64 bg-gray-800 dark:bg-gray-800 min-h-screen" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <!-- Logo/Title -->
        <div class="mb-8 px-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="block h-8 w-8 fill-current text-indigo-400" />
                <span class="text-xl font-bold text-white">Administrator</span>
            </a>
        </div>

        <!-- Main Navigation -->
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Websites -->
            <li>
                <a href="{{ route('admin.websites.index') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.websites.index') && !request()->route('website') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    All Websites
                </a>
            </li>

            <!-- Current Website Links (only when viewing a specific website) -->
            @if($currentWebsite)
            <div class="text-md font-semibold text-white overflow-hidden rounded-md">
                <div class="px-4 py-2 text-lg bg-gray-700 dark:bg-gray-900 border-b border-purple-500 dark:border-purple-500 ">
                    <a href="{{ route('admin.websites.show', $currentWebsite) }}" class="text-white">
                        {{ $currentWebsite->name }}
                    </a>
                </div>
                <ul class="bg-gray-700 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-50 text-white dark:text-gray-200">
                    <li>
                        <a href="{{ route('admin.websites.edit', $currentWebsite) }}" 
                        class="flex items-center p-2 {{ (request()->routeIs('admin.websites.edit')) && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Configuration
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.websites.homepage.edit', $currentWebsite) }}"
                        class="flex items-center p-2 {{ request()->routeIs('admin.websites.homepage.*') && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Homepage
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.websites.hours.index', $currentWebsite) }}"
                        class="flex items-center p-2 {{ request()->routeIs('admin.websites.hours.*') && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Store Hours
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.websites.menu.index', $currentWebsite) }}" 
                        class="flex items-center p-2 {{ request()->routeIs('admin.websites.menu.*') && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Manage Menu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.websites.pages.index', $currentWebsite) }}" 
                        class="flex items-center p-2 {{ request()->routeIs('admin.websites.pages.*') && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Manage Pages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.websites.images.index', $currentWebsite) }}"
                        class="flex items-center p-2 {{ request()->routeIs('admin.websites.images.*') && optional(request()->route('website'))->id === $currentWebsite->id ? 'bg-purple-800 text-white' : 'text-white dark:text-gray-200 hover:bg-gray-700 hover:text-white' }} transition">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Manage Images
                        </a>
                    </li>
                </ul>
            </div>

            @endif

            <!-- Divider -->
            <li class="my-4 border-t border-gray-700"></li>

            <!-- Quick Links -->
            <li>
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Quick Links</span>
            </li>


            <!-- Account -->
            <li>
                <a href="{{ route('admin.account') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.account*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Account
                </a>
            </li>

            <!-- Main Site -->
            <li>
                <a href="{{ route('welcome') }}" 
                   target="_blank"
                   class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    View Main Site
                </a>
            </li>
        </ul>
    </div>
</aside>
