<x-website-layout>
    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-800 dark:to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $website->name }}</h1>
                    @if($website->tagline)
                        <p class="text-xl md:text-2xl mb-8">{{ $website->tagline }}</p>
                    @endif
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('website.menu') }}" 
                           class="bg-white text-purple-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition">
                            View Menu
                        </a>
                        @if($website->contact_info && isset($website->contact_info['phone']))
                            <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                               class="bg-purple-700 hover:bg-purple-800 text-white px-8 py-3 rounded-lg font-semibold transition">
                                Call Us
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        @if($website->contact_info)
            @php
                $street = $website->contact_info['street_address'] ?? null;
                $suite = $website->contact_info['suite'] ?? null;
                $city = $website->contact_info['city'] ?? null;
                $state = $website->contact_info['state'] ?? null;
                $zip = $website->contact_info['zipcode'] ?? null;
                $country = $website->contact_info['country'] ?? null;
                $cityStateZip = trim(implode(' ', array_filter([$city, $state, $zip])));
                $fullAddress = implode(', ', array_filter([$street, $suite, $cityStateZip, $country]));
            @endphp
            @if(isset($website->contact_info['phone']) || isset($website->contact_info['email']) || $fullAddress)
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Contact Us</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if(isset($website->contact_info['phone']))
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Phone</h3>
                                    <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                                       class="text-purple-600 dark:text-purple-400 hover:underline">
                                        {{ $website->contact_info['phone'] }}
                                    </a>
                                </div>
                            @endif
                            @if(isset($website->contact_info['email']))
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
                                    <a href="mailto:{{ $website->contact_info['email'] }}" 
                                       class="text-purple-600 dark:text-purple-400 hover:underline">
                                        {{ $website->contact_info['email'] }}
                                    </a>
                                </div>
                            @endif
                            @if($fullAddress)
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Address</h3>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $fullAddress }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Hours -->
        @php
            $websiteTimezone = $website->timezone ?: 'America/New_York';
            $hours = \App\Models\StoreHour::where('website_id', $website->id)
                ->orderBy('day_of_week')
                ->get()
                ->keyBy('day_of_week');
            $days = \App\Models\StoreHour::daysSundayFirst();
            $hasAnyHours = $hours->count() > 0;
            $formatTimeLabel = function (?string $time): ?string {
                if (!$time) return null;
                $hhmm = substr((string) $time, 0, 5);
                $dt = \DateTime::createFromFormat('H:i', $hhmm, new \DateTimeZone('UTC'));
                return $dt ? $dt->format('g:i A') : $hhmm;
            };
        @endphp

        <!-- Featured Menu Items (if any) -->
        @php
            $featuredItems = \App\Models\MenuItem::where('website_id', $website->id)
                ->where('is_available', true)
                ->orderBy('sort_order')
                ->limit(6)
                ->get();
        @endphp
        
        @if($featuredItems->count() > 0)
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">Featured Items</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredItems as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            @if($item->image)
                                @php
                                    $imageUrl = null;
                                    if (is_string($item->image) && (str_starts_with($item->image, 'http://') || str_starts_with($item->image, 'https://'))) {
                                        $imageUrl = $item->image;
                                    } else {
                                        try {
                                            $imageUrl = \Illuminate\Support\Facades\Storage::disk('s3')->url($item->image);
                                        } catch (\Throwable $e) {
                                            $imageUrl = asset('storage/' . $item->image);
                                        }
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $item->name }}"
                                     class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $item->name }}</h3>
                                @if($item->description)
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($item->description, 100) }}</p>
                                @endif
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('website.menu') }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition inline-block">
                        View Full Menu
                    </a>
                </div>
            </div>
        @endif

        @if($hasAnyHours)
            <div id="hours" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Hours</h2>
                            </div>
                            <div class="shrink-0 text-purple-600 dark:text-purple-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-6 divide-y divide-gray-100 dark:divide-gray-700/60">
                            @foreach($days as $dayIndex => $label)
                                @php
                                    $row = $hours->get($dayIndex);
                                    $isClosed = $row ? (bool) $row->is_closed : false;
                                    $opens = $row && $row->opens_at ? $formatTimeLabel((string) $row->opens_at) : null;
                                    $closes = $row && $row->closes_at ? $formatTimeLabel((string) $row->closes_at) : null;
                                @endphp
                                <div class="flex items-center justify-between py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $label }}</div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        @if(!$row)
                                            <span class="text-gray-400 dark:text-gray-500">Not set</span>
                                        @elseif($isClosed)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Closed</span>
                                        @else
                                            {{ $opens }} – {{ $closes }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-website-layout>
