<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white dark:text-white">{{ $website->name }}</h1>
                    <p class="text-sm text-gray-400 dark:text-gray-400">{{ __('Website Overview & Configuration') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.websites.edit', $website) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                @if($website->domain || $website->subdomain)
                    <a href="{{ $current_active_uri }}" target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold text-sm shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        {{ __('Visit Site') }}
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4 space-y-6">
        <!-- Quick Status Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-extrabold text-gray-900 dark:text-white capitalize">{{ $website->status }}</span>
                        <div class="flex h-2 w-2 rounded-full {{ $website->status === 'active' ? 'bg-green-500' : ($website->status === 'trial' ? 'bg-blue-500' : 'bg-red-500') }}"></div>
                    </div>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Plan Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Plan</p>
                    <span class="text-xl font-extrabold text-gray-900 dark:text-white uppercase">{{ $website->plan }}</span>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
            </div>

            <!-- Timezone Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Timezone</p>
                    <span class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $website->timezone ?: 'America/New_York' }}</span>
                </div>
                <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Details Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ __('URL Details') }}</h3>
                        <span class="text-[10px] font-bold text-gray-400 bg-gray-50 dark:bg-gray-900 px-2 py-1 rounded">Website ID: {{ $website->id }}</span>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12">
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Live URL</label>
                                <a href="{{ $current_active_uri }}" target="_blank" class="text-sm font-bold text-gray-900 dark:text-white hover:text-indigo-600 transition-colors break-all">
                                    {{ $current_active_uri }}
                                </a>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Slug</label>
                                <p class="text-sm font-mono text-gray-600 dark:text-gray-300">/{{ $website->slug }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Custom Domain</label>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->domain ?: '—' }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Subdomain</label>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->subdomain ? $website->subdomain . '.localhost' : '—' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-1">Description</label>
                                <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed italic border-l-4 border-gray-100 dark:border-gray-700 pl-4 py-1">
                                    {{ $website->description ?: 'No description available for this restaurant.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shortcuts -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.websites.menu.index', $website) }}" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white">Menu Editor</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                    <a href="{{ route('admin.websites.pages.index', $website) }}" class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg text-green-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2-0 01-2-2V5a2 2-0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white">Page Builder</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            <!-- Meta/Sidebar Column -->
            <div class="space-y-6">
                <!-- Owner Section -->
                <div class="bg-gray-300 dark:bg-gray-700 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-6">Website Owner</h3>
                    @if($website->user)
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-12 w-12 rounded-xl bg-indigo-500 flex items-center justify-center font-black text-white shadow-lg shadow-indigo-500/20">
                                {{ substr($website->user->first_name, 0, 1) }}{{ substr($website->user->last_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold leading-none">{{ $website->user->full_name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $website->user->email }}</p>
                            </div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-500 dark:text-gray-300 uppercase">Access Level</span>
                            <span class="text-xs font-black text-indigo-400 uppercase tracking-tighter">{{ str_replace('_', ' ', $website->user->role) }}</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Unassigned</p>
                    @endif
                </div>

                <!-- Billing card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6">Cycle & Dates</h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 p-1 bg-gray-50 dark:bg-gray-900 rounded text-gray-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Registered</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @if($website->trial_ends_at)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 p-1 bg-blue-50 dark:bg-blue-900/20 rounded text-blue-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-blue-400 uppercase">Trial End</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    {{ $website->trial_ends_at->format('M d, Y') }}
                                    @if($website->trial_ends_at->isPast())
                                        <span class="text-[8px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full font-black uppercase">Ended</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                        @if($website->subscription_ends_at)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 p-1 bg-green-50 dark:bg-green-900/20 rounded text-green-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-green-400 uppercase">Next Payment</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $website->subscription_ends_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>