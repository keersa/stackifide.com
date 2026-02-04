<x-admin-layout>
    <x-admin-website-header :website="$website" title="Website Settings" />

        <div class="py-2">
            <div class="px-2 pb-4 flex items-center justify-between">
                <h3 class="font-black text-gray-900 dark:text-white text-2xl tracking-tighter">{{ __('Website Configuration') }}</h3>
            </div>
            <form method="POST" action="{{ route('admin.websites.update', $website) }}">
                @csrf
                @method('PUT')

                <!-- Website Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
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
                                <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tagline</label>
                                <input type="text"
                                       name="tagline"
                                       id="tagline"
                                       value="{{ old('tagline', $website->tagline) }}"
                                       placeholder="A short, catchy phrase that describes your restaurant"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('tagline')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        </div>
                    
                        <div class="md:col-span-2 mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" 
                                        id="description"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $website->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact & Address -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact & Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_info_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text"
                                       name="contact_info[phone]"
                                       id="contact_info_phone"
                                       value="{{ old('contact_info.phone', $website->contact_info['phone'] ?? '') }}"
                                       placeholder="(555) 123-4567"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                <input type="email"
                                       name="contact_info[email]"
                                       id="contact_info_email"
                                       value="{{ old('contact_info.email', $website->contact_info['email'] ?? '') }}"
                                       placeholder="contact@example.com"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="contact_info_street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                                <input type="text"
                                       name="contact_info[street_address]"
                                       id="contact_info_street_address"
                                       value="{{ old('contact_info.street_address', $website->contact_info['street_address'] ?? '') }}"
                                       placeholder="123 Main St"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.street_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_suite" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suite #</label>
                                <input type="text"
                                       name="contact_info[suite]"
                                       id="contact_info_suite"
                                       value="{{ old('contact_info.suite', $website->contact_info['suite'] ?? '') }}"
                                       placeholder="Suite 100"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.suite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                <input type="text"
                                       name="contact_info[city]"
                                       id="contact_info_city"
                                       value="{{ old('contact_info.city', $website->contact_info['city'] ?? '') }}"
                                       placeholder="New York"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                                <input type="text"
                                       name="contact_info[state]"
                                       id="contact_info_state"
                                       value="{{ old('contact_info.state', $website->contact_info['state'] ?? '') }}"
                                       placeholder="NY"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_zipcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Zipcode</label>
                                <input type="text"
                                       name="contact_info[zipcode]"
                                       id="contact_info_zipcode"
                                       value="{{ old('contact_info.zipcode', $website->contact_info['zipcode'] ?? '') }}"
                                       placeholder="10001"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('contact_info.zipcode')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_info_country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                <select name="contact_info[country]"
                                        id="contact_info_country"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach($countries ?? [] as $country)
                                        <option value="{{ $country }}" {{ old('contact_info.country', $website->contact_info['country'] ?? 'United States') === $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('contact_info.country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
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
                        </div>
                    </div>
                </div>

                <!-- Social Media & Links -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Social Media & Links</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Add links to your social profiles and review sites. These can be displayed on your public website.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(config('social_links.links', []) as $key => $config)
                                <div>
                                    <label for="social_links_{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $config['label'] }}</label>
                                    <input type="url"
                                           name="social_links[{{ $key }}]"
                                           id="social_links_{{ $key }}"
                                           value="{{ old("social_links.{$key}", $website->social_links[$key] ?? '') }}"
                                           placeholder="{{ $config['placeholder'] ?? '' }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error("social_links.{$key}")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
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

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('contact_info_phone');
        if (!phoneInput) return;

        function formatPhone(value) {
            const digits = value.replace(/\D/g, '').slice(0, 10);
            if (digits.length === 0) return '';
            if (digits.length <= 3) return '(' + digits;
            if (digits.length <= 6) return '(' + digits.slice(0, 3) + ') ' + digits.slice(3);
            return '(' + digits.slice(0, 3) + ') ' + digits.slice(3, 6) + '-' + digits.slice(6);
        }

        phoneInput.addEventListener('input', function(e) {
            e.target.value = formatPhone(e.target.value);
        });

        // Format initial value on load (handles existing data in various formats)
        if (phoneInput.value) {
            phoneInput.value = formatPhone(phoneInput.value);
        }
    });
    </script>
    @endpush
</x-admin-layout>
