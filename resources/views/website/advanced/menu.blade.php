<x-website-layout>
    <div class="min-h-screen bg-amber-50/50 dark:bg-gray-950 overflow-x-hidden">
        <!-- Header -->
        <div class="relative overflow-hidden min-h-[40vh] sm:min-h-[45vh] flex flex-col justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 dark:from-amber-900 dark:via-amber-950 dark:to-gray-900"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.3\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
                <a href="{{ route('website.home') }}" 
                   class="inline-flex items-center gap-2 text-amber-100 hover:text-white transition-colors mb-6 sm:mb-8 group min-h-[44px] items-center">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm sm:text-base">Back to Home</span>
                </a>
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-1 sm:mb-2">{{ $website->name }}</h1>
                <p class="text-amber-200/90 text-base sm:text-lg md:text-xl">Our Menu</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24">
            @forelse($menuItems as $category => $items)
                <div class="mb-16 sm:mb-20 first:mt-0">
                    @if($category)
                        <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 mb-8 sm:mb-10">
                            <div class="h-px w-full sm:w-auto sm:flex-1 bg-gradient-to-r from-transparent via-amber-300 dark:via-amber-600 to-transparent sm:max-w-[80px] lg:max-w-[120px]"></div>
                            <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white text-center sm:text-left whitespace-nowrap">
                                {{ $category }}
                            </h2>
                            <div class="h-px w-full sm:w-auto sm:flex-1 bg-gradient-to-r from-transparent via-amber-300 dark:via-amber-600 to-transparent sm:max-w-[80px] lg:max-w-[120px]"></div>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
                        @foreach($items as $item)
                            <div class="website-card-hover group bg-white dark:bg-gray-800/90 rounded-xl sm:rounded-2xl overflow-hidden shadow-lg border border-amber-100/50 dark:border-gray-700/50 {{ !$item->is_available ? 'opacity-75' : '' }}">
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
                                    <div class="relative overflow-hidden aspect-[4/3]">
                                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                        @if(!$item->is_available)
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                                <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-white/90 dark:bg-gray-800/90 rounded-full text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200">Unavailable</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="p-4 sm:p-5 lg:p-8">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 sm:gap-4 mb-2 sm:mb-3">
                                        <h3 class="font-display text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                            {{ $item->name }}
                                        </h3>
                                        <span class="text-lg sm:text-xl font-bold text-amber-600 dark:text-amber-400 shrink-0">
                                            ${{ number_format($item->price, 2) }}
                                        </span>
                                    </div>
                                    @if($item->description)
                                        <p class="text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 leading-relaxed text-sm sm:text-base">{{ $item->description }}</p>
                                    @endif
                                    @if($item->dietary_info && is_array($item->dietary_info) && count($item->dietary_info) > 0)
                                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                            @foreach($item->dietary_info as $dietary)
                                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">
                                                    {{ ucfirst($dietary) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-16 sm:py-24 px-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-5 sm:mb-6 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="font-display text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">Menu Coming Soon</h2>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto text-sm sm:text-base">We're crafting something delicious. Check back soon for our full menu.</p>
                    <a href="{{ route('website.home') }}" class="inline-flex items-center gap-2 mt-5 sm:mt-6 text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 font-semibold transition-colors min-h-[44px] items-center">
                        ← Back to Home
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-website-layout>
