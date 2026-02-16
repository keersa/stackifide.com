<x-website-layout>
    @php
        $colorSettings = $website->color_settings ?? [];
        $heroBgEnabled = !empty($colorSettings['hero_background']['enabled']);
        $heroHeadingEnabled = !empty($colorSettings['hero_heading']['enabled']);
        $heroTextEnabled = !empty($colorSettings['hero_text']['enabled']);
        $bodyBgEnabled = !empty($colorSettings['website_body']['enabled']);
    @endphp
    <div class="min-h-screen overflow-x-hidden {{ !$bodyBgEnabled ? 'bg-amber-50/50 dark:bg-gray-950' : 'website-body-override' }}">
        <!-- Hero Section - Bold & Layered -->
        <div class="relative overflow-hidden min-h-[70vh] sm:min-h-[75vh] lg:min-h-[85vh] flex flex-col justify-center">
            <div class="absolute inset-0 {{ !$heroBgEnabled ? 'bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 dark:from-amber-900 dark:via-amber-950 dark:to-gray-900' : 'website-hero-bg-override' }}"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            <!-- Decorative floating shapes -->
            <div class="absolute top-10 right-10 w-32 h-32 sm:w-40 sm:h-40 rounded-full bg-white/5 blur-2xl advanced-fade-in advanced-stagger-3"></div>
            <div class="absolute bottom-20 left-10 w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-amber-300/10 blur-xl advanced-fade-in advanced-stagger-4"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-28">
                <div class="text-center">
                    @php
                        $logoUrl = $website->logo_rect_url;
                    @endphp
                    <p class="text-amber-200 dark:text-amber-300/80 text-xs sm:text-sm uppercase tracking-[0.25em] sm:tracking-[0.3em] font-medium mb-3 sm:mb-4 advanced-fade-in {{ $heroTextEnabled ? 'website-hero-text-override' : '' }}">Welcome to</p>
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $website->name }} Logo" class="mx-auto h-auto max-w-[400px] object-contain mb-5">
                    @else
                        <h1 class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold text-white mb-4 sm:mb-6 drop-shadow-lg tracking-tight advanced-fade-in advanced-stagger-1 {{ $heroHeadingEnabled ? 'website-hero-heading-override' : '' }}">
                            {{ $website->name }}
                        </h1>
                    @endif
                    @if($website->tagline)
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-amber-100/95 max-w-2xl mx-auto mb-8 sm:mb-12 leading-relaxed px-2 advanced-fade-in advanced-stagger-2 {{ $heroTextEnabled ? 'website-hero-text-override' : '' }}">
                            {{ $website->tagline }}
                        </p>
                    @endif
                    @if($website->contact_info && isset($website->contact_info['phone']))
                        <div class="flex justify-center advanced-fade-in advanced-stagger-3">
                            <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border-2 border-white/80 text-white hover:bg-white/20 px-6 sm:px-8 py-3.5 sm:py-4 rounded-full font-semibold transition-all backdrop-blur-sm min-h-[48px] sm:min-h-0">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Call Us
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 sm:h-20 lg:h-24 xl:h-[120px]">
                    <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor" class="text-amber-50/50 dark:text-gray-950"/>
                </svg>
            </div>
        </div>

        @php
            $featuredItems = \App\Models\MenuItem::where('website_id', $website->id)
                ->where('is_available', true)
                ->orderBy('sort_order')
                ->limit(6)
                ->get();
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
            $street = $website->contact_info['street_address'] ?? null;
            $suite = $website->contact_info['suite'] ?? null;
            $city = $website->contact_info['city'] ?? null;
            $state = $website->contact_info['state'] ?? null;
            $zip = $website->contact_info['zipcode'] ?? null;
            $country = $website->contact_info['country'] ?? null;
            $cityStateZip = trim(implode(' ', array_filter([$city, $state, $zip])));
            $fullAddress = implode(', ', array_filter([$street, $suite, $cityStateZip, $country]));
        @endphp

        @if($featuredItems->count() > 0)
            <div class="relative -mt-8 sm:-mt-12 lg:-mt-16 z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 sm:pb-16 lg:pb-20">
                <div class="text-center mb-8 sm:mb-12">
                    <span class="text-amber-600 dark:text-amber-500 text-xs sm:text-sm font-semibold uppercase tracking-widest">Taste & Discover</span>
                    <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mt-2">Featured Dishes</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
                    @foreach($featuredItems as $index => $item)
                        <div class="website-card-hover group bg-white dark:bg-gray-800/90 rounded-2xl shadow-xl overflow-hidden border border-amber-100/50 dark:border-gray-700/50 advanced-fade-in-up opacity-0 advanced-stagger-{{ min($index + 1, 6) }}">
                            @if($item->image)
                                @php
                                    $imageUrl = null;
                                    if (is_string($item->image) && (str_starts_with($item->image, 'http://') || str_starts_with($item->image, 'https://'))) {
                                        $imageUrl = $item->image;
                                    } else {
                                        try {
                                            $imageUrl = '/storage/' . ltrim($item->image, '/');
                                        } catch (\Throwable $e) {
                                            $imageUrl = asset('storage/' . $item->image);
                                        }
                                    }
                                @endphp
                                <div class="relative overflow-hidden aspect-[4/3]">
                                    <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                            @endif
                            <div class="p-5 sm:p-6 lg:p-8">
                                <h3 class="font-display text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $item->name }}</h3>
                                @if($item->description)
                                    <p class="text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 line-clamp-2 text-sm sm:text-base">{{ Str::limit($item->description, 100) }}</p>
                                @endif
                                <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400">${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">
                @if($website->contact_info && (isset($website->contact_info['phone']) || isset($website->contact_info['email']) || $fullAddress))
                    <div class="relative order-2 lg:order-1">
                        <div class="bg-white dark:bg-gray-800/80 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xl border border-amber-100/50 dark:border-gray-700/50">
                            <h2 class="font-display text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-5 sm:mb-6 flex items-center gap-3">
                                <span class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                Get in Touch
                            </h2>
                            <div class="space-y-4 sm:space-y-6">
                                @if(isset($website->contact_info['phone']))
                                    <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                                       class="flex items-center gap-3 sm:gap-4 text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors group py-2 -my-2">
                                        <span class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center shrink-0 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </span>
                                        <span class="font-medium text-base sm:text-lg">{{ $website->contact_info['phone'] }}</span>
                                    </a>
                                @endif
                                @if(isset($website->contact_info['email']))
                                    <a href="mailto:{{ $website->contact_info['email'] }}" 
                                       class="flex items-center gap-3 sm:gap-4 text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors group py-2 -my-2">
                                        <span class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center shrink-0 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <span class="font-medium text-base sm:text-lg break-all">{{ $website->contact_info['email'] }}</span>
                                    </a>
                                @endif
                                @if($fullAddress)
                                    <div class="flex items-start gap-3 sm:gap-4 text-gray-700 dark:text-gray-300 py-2 -my-2">
                                        <span class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <p class="font-medium text-base sm:text-lg pt-2">{{ $fullAddress }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($hasAnyHours)
                    <div id="hours" class="relative order-1 lg:order-2">
                        <div class="bg-white dark:bg-gray-800/80 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-10 shadow-xl border border-amber-100/50 dark:border-gray-700/50">
                            <h2 class="font-display text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-5 sm:mb-6 flex items-center gap-3">
                                <span class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center shrink-0">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Hours
                            </h2>
                            <div class="divide-y divide-amber-100 dark:divide-gray-700/60">
                                @foreach($days as $dayIndex => $label)
                                    @php
                                        $row = $hours->get($dayIndex);
                                        $isClosed = $row ? (bool) $row->is_closed : false;
                                        $opens = $row && $row->opens_at ? $formatTimeLabel((string) $row->opens_at) : null;
                                        $closes = $row && $row->closes_at ? $formatTimeLabel((string) $row->closes_at) : null;
                                    @endphp
                                    <div class="flex items-center justify-between py-3 sm:py-4 first:pt-0 gap-4">
                                        <span class="font-medium text-gray-900 dark:text-gray-100 text-sm sm:text-base">{{ $label }}</span>
                                        <span class="text-gray-600 dark:text-gray-400 text-sm sm:text-base text-right shrink-0">
                                            @if(!$row)
                                                <span class="text-gray-400 dark:text-gray-500">—</span>
                                            @elseif($isClosed)
                                                <span class="inline-flex items-center px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">Closed</span>
                                            @else
                                                {{ $opens }} – {{ $closes }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Google Map -->
       @if($fullAddress && $street && config('services.google.maps_api_key'))
            <div class="w-full">
                <div class="relative h-[400px] sm:h-[450px] lg:h-[500px] w-full">
                    <iframe
                        src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_api_key') }}&q={{ urlencode($fullAddress) }}"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Map showing {{ $fullAddress }}">
                    </iframe>
                    <div class="absolute inset-0 hidden dark:block bg-gray-900/35 pointer-events-none" aria-hidden="true"></div>
                </div>
            </div>
        @endif
    </div>
</x-website-layout>
