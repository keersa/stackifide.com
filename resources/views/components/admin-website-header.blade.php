@props(['website', 'title', 'subtitle' => 'Website Overview & Configuration', 'showStats' => false])

@php
    $logoUrl = $website->logo_url;
    
    // Determine the current URL for the "Visit Site" button
    $current_active_uri = '#';
    if ($website->domain) {
        $current_active_uri = 'http://' . $website->domain;
    } elseif ($website->subdomain) {
        $current_active_uri = 'http://' . $website->subdomain . '.localhost:8000';
    } else {
        $current_active_uri = 'http://' . $website->slug . '.localhost:8000';
    }
@endphp

<x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-0 m-0 overflow-hidden min-w-[48px]">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" class="max-h-10 w-auto object-contain p-0 m-0 rounded-md" alt="Website Logo">
                @else
                    <div class="flex items-center justify-center min-h-[40px] min-w-[40px] bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-md">
                        <svg class="w-6 h-6 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white dark:text-white">{{ $website->name }}</h1>
                <p class="text-sm text-gray-400 dark:text-gray-400">{{ $title }}</p>
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

@if($showStats)
<!-- Quick Status Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Status Card -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
            <div class="flex items-center gap-2">
                <span class="text-xl font-extrabold text-gray-900 dark:text-white capitalize">{{ $website->status }}</span>
                <div class="flex h-2 w-2 rounded-full {{ $website->status === 'active' ? 'bg-lime-400' : ($website->status === 'trial' ? 'bg-blue-500' : 'bg-red-500') }}"></div>
            </div>
        </div>
        <div class="p-3 bg-gray-200 dark:bg-gray-900/50 rounded-lg">
            <svg class="w-6 h-6 text-lime-700 dark:text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
@endif
