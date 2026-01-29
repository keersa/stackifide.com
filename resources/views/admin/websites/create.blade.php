<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Create New Website') }}</span>
            <a href="{{ route('admin.websites.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Websites
            </a>
        </div>
    </x-slot>

    <div>
            <form method="POST" action="{{ route('admin.websites.store') }}" class="space-y-6">
                @csrf

                <!-- Website Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Website Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Restaurant Name *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old('name') }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                                <input type="text" 
                                       name="slug" 
                                       id="slug"
                                       value="{{ old('slug') }}"
                                       placeholder="Auto-generated if left empty"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <p class="mt-1 text-sm text-gray-500">URL-friendly identifier</p>
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Domain</label>
                                <input type="text" 
                                       name="domain" 
                                       id="domain"
                                       value="{{ old('domain') }}"
                                       placeholder="restaurant.com"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('domain')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subdomain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subdomain</label>
                                <input type="text" 
                                       name="subdomain" 
                                       id="subdomain"
                                       value="{{ old('subdomain') }}"
                                       placeholder="restaurant"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <p class="mt-1 text-sm text-gray-500">Will create: subdomain.stackifide.com</p>
                                @error('subdomain')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                                <select name="status" 
                                        id="status"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <p class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">New sites start with no plan. Subscribe to Basic or Pro from the website dashboard after creation.</p>
                            </div>
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="trial_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trial Ends At</label>
                                <input type="date" 
                                       name="trial_ends_at" 
                                       id="trial_ends_at"
                                       value="{{ old('trial_ends_at') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="subscription_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Ends At</label>
                                <input type="date" 
                                       name="subscription_ends_at" 
                                       id="subscription_ends_at"
                                       value="{{ old('subscription_ends_at') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Website
                    </button>
                </div>
            </form>
    </div>
</x-admin-layout>
