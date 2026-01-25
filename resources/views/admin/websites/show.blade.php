<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Website Details') }}: {{ $website->name }}</span>
        </div>
    </x-slot>

    <div class="space-y-6">
            <!-- Website Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Website Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->name }}</p>
                        </div>
                        @if($website->domain || $website->subdomain)
                        <div class="">
                            <a href="{{ $current_active_uri }}" target="_blank" class="inline-block border-2 border-lime-500 dark:border-gray-800 text-gray-700 dark:text-black bg-lime-400 hover:bg-lime-300 border py-1 px-6 rounded-xl transition-all">
                                <div class="text-md font-black leading-none">Current Active URL</div>
                                <div class="text-sm">{{ $current_active_uri }}</div>
                            </a>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Slug</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->slug }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($website->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($website->status === 'trial') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($website->status === 'suspended') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endif">
                                    {{ ucfirst($website->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Plan</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($website->plan) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Timezone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $website->timezone ?: 'America/New_York' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->created_at->format('M d, Y') }}</p>
                        </div>
                        
                        @if($website->description)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->description }}</p>
                        </div>
                        @endif
                        
                        @if($website->trial_ends_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Trial Ends At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->trial_ends_at->format('M d, Y') }}</p>
                        </div>
                        @endif
                        @if($website->subscription_ends_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Subscription Ends At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->subscription_ends_at->format('M d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Owner Information -->
            @if($website->user)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Owner</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->user->full_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Role</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst(str_replace('_', ' ', $website->user->role)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="text-right py-2">
                <a href="{{ route('admin.websites.edit', $website) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit Website
                </a>
            </div>

    </div>
</x-admin-layout>
