<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Website Details') }}</span>
            <div class="flex gap-2">
                <a href="{{ route('super-admin.websites.edit', $website) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('super-admin.websites.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Websites
                </a>
            </div>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Slug</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->slug }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Domain</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->domain ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Subdomain</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->subdomain ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($website->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($website->status === 'trial') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($website->status === 'suspended') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                            @endif">
                            {{ ucfirst($website->status) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Plan</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($website->plan) }}</p>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $website->updated_at->format('M d, Y H:i') }}</p>
                    </div>
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
    </div>
</x-super-admin-layout>
