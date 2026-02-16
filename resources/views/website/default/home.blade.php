<x-website-layout>
    @php
        $colorSettings = $website->color_settings ?? [];
        $heroBgEnabled = !empty($colorSettings['hero_background']['enabled']);
        $heroHeadingEnabled = !empty($colorSettings['hero_heading']['enabled']);
        $heroTextEnabled = !empty($colorSettings['hero_text']['enabled']);
        $bodyBgEnabled = !empty($colorSettings['website_body']['enabled']);
        $contactInfo = $website->contact_info ?? [];
        $street = $contactInfo['street_address'] ?? null;
        $suite = $contactInfo['suite'] ?? null;
        $city = $contactInfo['city'] ?? null;
        $state = $contactInfo['state'] ?? null;
        $zip = $contactInfo['zipcode'] ?? null;
        $country = $contactInfo['country'] ?? null;
        $cityStateZip = trim(implode(' ', array_filter([$city, $state, $zip])));
        $fullAddress = implode(', ', array_filter([$street, $suite, $cityStateZip, $country]));
    @endphp
    <div class="min-h-screen {{ !$bodyBgEnabled ? 'bg-slate-50 dark:bg-slate-950' : 'website-body-override' }}">
        <!-- Hero Section -->
        <div class="relative overflow-hidden text-white {{ !$heroBgEnabled ? 'bg-gradient-to-br from-slate-800 via-slate-900 to-cyan-950 dark:from-slate-900 dark:via-slate-950 dark:to-cyan-950' : 'website-hero-bg-override' }}">
            <!-- Subtle dot pattern overlay -->
            <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;" aria-hidden="true"></div>
            <!-- Soft glow accent -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="absolute -bottom-12 -left-12 w-72 h-72 bg-slate-400/10 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-32">
                <div class="text-center">
                    @php
                        $showLogoInHero = $website->show_logo_in_hero ?? true;
                        $heroTitle = $website->hero_title ?: $website->name;
                        $logoUrl = $website->logo_rect_url;
                        $showLogo = $showLogoInHero && $logoUrl;
                    @endphp
                    @if($showLogo)
                        <img src="{{ $logoUrl }}" alt="{{ $website->name }} Logo" class="mx-auto h-auto max-w-[400px] object-contain mb-5">
                    @else
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight mb-5 {{ $heroHeadingEnabled ? 'website-hero-heading-override' : '' }}">{{ $website->name }}</h1>
                    @endif
                    
                    @if($website->hero_title) 
                        <h3 class="text-2xl pb-8 {{ $heroTextEnabled ? 'website-hero-text-override' : '' }}">{{ $website->hero_title }}</h3>
                    @elseif($website->tagline)
                        <h3 class="text-2xl pb-8 {{ $heroTextEnabled ? 'website-hero-text-override' : '' }}">{{ $website->tagline }}</h3>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('website.menu') }}" 
                           class="inline-flex items-center justify-center bg-cyan-500 hover:bg-cyan-400 text-slate-900 px-8 py-3.5 rounded-lg font-semibold transition-all shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 hover:-translate-y-0.5">
                            View Menu
                        </a>
                        @if($website->contact_info && isset($website->contact_info['phone']))
                            <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                               class="inline-flex items-center justify-center border-2 border-white/30 hover:border-white/60 hover:bg-white/10 text-white px-8 py-3.5 rounded-lg font-semibold transition-all">
                                Call Us
                            </a>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        @if($website->contact_info && (isset($website->contact_info['phone']) || isset($website->contact_info['email']) || $fullAddress))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 dark:shadow-none ring-1 ring-slate-200/60 dark:ring-slate-700/50 overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-cyan-500 to-cyan-600 rounded-l-2xl" aria-hidden="true"></div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white mb-8 flex items-center gap-2">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </span>
                        Contact Us
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pl-2">
                        @if(isset($website->contact_info['phone']))
                            <div>
                                <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Phone</h3>
                                <a href="tel:{{ preg_replace('/\D/', '', $website->contact_info['phone']) }}" 
                                   class="text-lg font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 dark:hover:text-cyan-300 transition-colors">
                                    {{ $website->contact_info['phone'] }}
                                </a>
                            </div>
                        @endif
                        @if(isset($website->contact_info['email']))
                            <div>
                                <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email</h3>
                                <a href="mailto:{{ $website->contact_info['email'] }}" 
                                   class="text-lg font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 dark:hover:text-cyan-300 transition-colors break-all">
                                    {{ $website->contact_info['email'] }}
                                </a>
                            </div>
                        @endif
                        @if($fullAddress)
                            <div>
                                <h3 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Address</h3>
                                <p class="text-lg font-medium text-slate-700 dark:text-slate-300">{{ $fullAddress }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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
            <div class="bg-white dark:bg-slate-900/50 py-16 sm:py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <p class="text-cyan-600 dark:text-cyan-400 text-sm font-semibold tracking-widest uppercase mb-2">Taste & Discover</p>
                        <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">Featured Items</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($featuredItems as $item)
                            <div class="group bg-white dark:bg-slate-800/80 rounded-xl overflow-hidden ring-1 ring-slate-200/60 dark:ring-slate-700/50 hover:ring-cyan-500/50 dark:hover:ring-cyan-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-slate-900/50">
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
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $item->name }}"
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-32 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">{{ $item->name }}</h3>
                                    @if($item->description)
                                        <p class="text-slate-600 dark:text-slate-400 mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    @endif
                                    <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-10">
                        <a href="{{ route('website.menu') }}" 
                           class="inline-flex items-center gap-2 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-200 px-8 py-3.5 rounded-lg font-semibold transition-all">
                            View Full Menu
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($hasAnyHours)
            <div id="hours" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
                <div class="max-w-2xl mx-auto">
                    <div class="relative bg-white dark:bg-slate-900 rounded-2xl overflow-hidden ring-1 ring-slate-200/60 dark:ring-slate-700/50 shadow-xl shadow-slate-200/50 dark:shadow-none">
                        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-cyan-500 to-cyan-600" aria-hidden="true"></div>
                        <div class="p-6 sm:p-8 pl-8">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </span>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Hours</h2>
                            </div>
                            <div class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                @foreach($days as $dayIndex => $label)
                                    @php
                                        $row = $hours->get($dayIndex);
                                        $isClosed = $row ? (bool) $row->is_closed : false;
                                        $opens = $row && $row->opens_at ? $formatTimeLabel((string) $row->opens_at) : null;
                                        $closes = $row && $row->closes_at ? $formatTimeLabel((string) $row->closes_at) : null;
                                    @endphp
                                    <div class="flex items-center justify-between py-4 first:pt-0">
                                        <span class="font-medium text-slate-900 dark:text-slate-100">{{ $label }}</span>
                                        <span class="text-slate-600 dark:text-slate-400">
                                            @if(!$row)
                                                <span class="text-slate-400 dark:text-slate-500">Not set</span>
                                            @elseif($isClosed)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">Closed</span>
                                            @else
                                                {{ $opens }} – {{ $closes }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Google Map -->
        @if($fullAddress && $street && config('services.google.maps_api_key'))
            <div class="w-full">
                <div class="relative h-[400px] sm:h-[450px] lg:h-[500px] w-full ring-1 ring-slate-200/60 dark:ring-slate-800">
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
                    <div class="absolute inset-0 hidden dark:block bg-slate-950/30 pointer-events-none" aria-hidden="true"></div>
                </div>
            </div>
        @endif
    </div>
</x-website-layout>
