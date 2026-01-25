@props(['active' => null])

@php
    $user = auth()->user();
    // Only show websites created by the current user
    $websites = \App\Models\Website::where('user_id', $user->id)
        ->orderBy('name')
        ->get();
    
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
    elseif (request()->routeIs('admin.websites.show') || 
            request()->routeIs('admin.websites.menu.*') || 
            request()->routeIs('admin.websites.pages.*')) {
        $segments = request()->segments();
        $websiteIndex = array_search('websites', $segments);
        if ($websiteIndex !== false && isset($segments[$websiteIndex + 1])) {
            $websiteIdOrSlug = $segments[$websiteIndex + 1];
            // Try to find by ID first, then by slug
            $currentWebsite = \App\Models\Website::where('id', $websiteIdOrSlug)
                ->orWhere('slug', $websiteIdOrSlug)
                ->first();
        }
    }
    
    // Determine which website menu should be open based on current route
    $openWebsiteId = null;
    if ($currentWebsite) {
        $openWebsiteId = $currentWebsite->id;
    }
@endphp

<aside x-data="{ 
    openWebsiteId: {{ $openWebsiteId ? $openWebsiteId : 'null' }},
    toggleWebsite(websiteId) {
        this.openWebsiteId = this.openWebsiteId === websiteId ? null : websiteId;
    }
}" 
       class="w-64 bg-gray-800 dark:bg-gray-800 min-h-screen" 
       aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <!-- Logo/Title -->
        <div class="mb-8 px-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="block h-8 w-8 fill-current text-indigo-400" />
                <span class="text-xl font-bold text-white">Admin Panel</span>
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

            <!-- Individual Websites -->
            @if($websites->count() > 0)
                @foreach($websites as $website)
                    <li>
                        <button type="button" 
                                class="flex items-center w-full p-2 rounded-lg {{ $currentWebsite && $currentWebsite->id === $website->id ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition"
                                @click="toggleWebsite({{ $website->id }})">
                            <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="truncate flex-1 text-left">{{ $website->name }}</span>
                            <svg class="w-3 h-3 ms-auto transition-transform" 
                                 :class="{ 'rotate-180': openWebsiteId === {{ $website->id }} }"
                                 fill="none" 
                                 stroke="currentColor" 
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul x-show="openWebsiteId === {{ $website->id }}" 
                            x-transition:enter="transition ease-out duration-400 transform"
                            x-transition:leave="transition ease-in duration-400 transform"
                            class="ms-6 mt-2 space-y-1">
                            <li>
                                <a href="{{ route('admin.websites.show', $website) }}" 
                                   class="flex items-center p-2 rounded-lg {{ (request()->routeIs('admin.websites.show') || request()->routeIs('admin.websites.edit')) && optional(request()->route('website'))->id === $website->id ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }} transition text-sm">
                                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Website Info
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.websites.menu.index', $website) }}" 
                                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.websites.menu.*') && optional(request()->route('website'))->id === $website->id ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }} transition text-sm">
                                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Manage Menu
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.websites.pages.index', $website) }}" 
                                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.websites.pages.*') && optional(request()->route('website'))->id === $website->id ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }} transition text-sm">
                                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Manage Pages
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.websites.hours.index', $website) }}"
                                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('admin.websites.hours.*') && optional(request()->route('website'))->id === $website->id ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }} transition text-sm">
                                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Store Hours
                                </a>
                            </li>
                        </ul>
                    </li>
                @endforeach
            @endif

            <!-- Divider -->
            <li class="my-4 border-t border-gray-700"></li>

            <!-- Quick Links -->
            <li>
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Quick Links</span>
            </li>


            <!-- Profile -->
            <li>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
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
