<x-admin-layout>
    <x-admin-website-header :website="$website" title="Edit Website Settings" />

    <div class="py-4">
            <form method="POST" action="{{ route('admin.websites.update', $website) }}" class="space-y-6">
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
                                       value="{{ old('slug', $website->slug) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Domain</label>
                                <input type="text" 
                                       name="domain" 
                                       id="domain"
                                       value="{{ old('domain', $website->domain) }}"
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
                                       value="{{ old('subdomain', $website->subdomain) }}"
                                       placeholder="restaurant"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $website->description) }}</textarea>
                            </div>
                            <div class="md:col-span-2">
                                @php
                                    $defaultTimezone = 'America/New_York';
                                    $timezones = \DateTimeZone::listIdentifiers();
                                    $selectedTimezone = old('timezone', $website->timezone ?? $defaultTimezone);
                                    $formatOffset = function (int $seconds): string {
                                        $sign = $seconds >= 0 ? '+' : '-';
                                        $seconds = abs($seconds);
                                        $hours = (int) floor($seconds / 3600);
                                        $mins = (int) floor(($seconds % 3600) / 60);
                                        return sprintf('UTC%s%02d:%02d', $sign, $hours, $mins);
                                    };
                                @endphp
                                <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                                <select name="timezone"
                                        id="timezone"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach($timezones as $tz)
                                        @php
                                            $offsetSeconds = (new \DateTime('now', new \DateTimeZone($tz)))->getOffset();
                                            $offsetLabel = $formatOffset($offsetSeconds);
                                        @endphp
                                        <option value="{{ $tz }}" {{ $selectedTimezone === $tz ? 'selected' : '' }}>
                                            {{ $tz }} ({{ $offsetLabel }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="trial_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trial Ends At</label>
                                <input type="date" 
                                       name="trial_ends_at" 
                                       id="trial_ends_at"
                                       value="{{ old('trial_ends_at', $website->trial_ends_at?->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="subscription_ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subscription Ends At</label>
                                <input type="date" 
                                       name="subscription_ends_at" 
                                       id="subscription_ends_at"
                                       value="{{ old('subscription_ends_at', $website->subscription_ends_at?->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Update Website
                    </button>
                </div>
            </form>
    </div>
</x-admin-layout>
