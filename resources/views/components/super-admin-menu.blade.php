@props(['active' => null])

<aside class="w-64 bg-purple-900 dark:bg-purple-950 min-h-screen" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <!-- Logo/Title -->
        <div class="mb-8 px-3">
            <a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="block h-8 w-8 fill-current text-purple-300" />
                <span class="text-xl font-bold text-white">Super Admin</span>
            </a>
        </div>

        <!-- Main Navigation -->
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('super-admin.dashboard') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('super-admin.dashboard') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('super-admin.users.index') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('super-admin.users.*') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>
            </li>

            <!-- Websites -->
            <li>
                <a href="{{ route('super-admin.websites.index') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('super-admin.websites.*') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Websites
                </a>
            </li>

            <!-- Leads -->
            <li>
                <a href="{{ route('super-admin.leads.index') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('super-admin.leads.*') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Leads
                </a>
            </li>

            <!-- Logs -->
            <li>
                <a href="{{ route('super-admin.logs.index') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('super-admin.logs.*') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Activity Logs
                </a>
            </li>

            <!-- Divider -->
            <li class="my-4 border-t border-purple-700"></li>

            <!-- Quick Links -->
            <li>
                <span class="px-3 text-xs font-semibold text-purple-300 uppercase">Quick Links</span>
            </li>

            <!-- Admin Panel -->
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-2 rounded-lg text-purple-200 hover:bg-purple-800 hover:text-white transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Admin Panel
                </a>
            </li>

            <!-- User Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center p-2 rounded-lg text-purple-200 hover:bg-purple-800 hover:text-white transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    User Dashboard
                </a>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center p-2 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-purple-700 text-white' : 'text-purple-200 hover:bg-purple-800 hover:text-white' }} transition">
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
                   class="flex items-center p-2 rounded-lg text-purple-200 hover:bg-purple-800 hover:text-white transition">
                    <svg class="w-5 h-5 me-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    View Main Site
                </a>
            </li>
        </ul>
    </div>
</aside>
