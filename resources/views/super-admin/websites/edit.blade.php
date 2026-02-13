<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Edit Website') }}</span>
            <a href="{{ route('super-admin.websites.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Websites
            </a>
        </div>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('super-admin.websites.update', $website) }}" class="space-y-6">
            @csrf
            @method('PUT')

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
                                   value="{{ old('name', $website->name) }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Domain</label>
                            <input type="text" 
                                   name="domain" 
                                   id="domain"
                                   value="{{ old('domain', $website->domain) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('domain')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                            <select name="status" 
                                    id="status"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $website->status) === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan *</label>
                            <select name="plan" 
                                    id="plan"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan }}" {{ old('plan', $website->plan) === $plan ? 'selected' : '' }}>
                                        {{ ucfirst($plan) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                            <select name="theme" 
                                    id="theme"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="default" {{ old('theme', $website->theme ?? 'default') === 'default' ? 'selected' : '' }}>Default</option>
                                <option value="advanced" {{ old('theme', $website->theme ?? 'default') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Visual theme for the public website.</p>
                            @error('theme')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Owner (User) *</label>
                            <select name="user_id" 
                                    id="user_id"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Select a user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $website->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }} ({{ $user->email }}) - {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" 
                                      id="description"
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $website->description) }}</textarea>
                        </div>
                        <div>
                            <label for="trial_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trial Ends At</label>
                            <input type="date" 
                                   name="trial_ends_at" 
                                   id="trial_ends_at"
                                   value="{{ old('trial_ends_at', $website->trial_ends_at ? $website->trial_ends_at->format('Y-m-d') : '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label for="subscription_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Ends At</label>
                            <input type="date" 
                                   name="subscription_ends_at" 
                                   id="subscription_ends_at"
                                   value="{{ old('subscription_ends_at', $website->subscription_ends_at ? $website->subscription_ends_at->format('Y-m-d') : '') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Update Website
                </button>
            </div>
        </form>
    </div>
</x-super-admin-layout>
