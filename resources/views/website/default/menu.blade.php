<x-website-layout>
    @php
        $cs = $website->color_settings ?? [];
        $bodyBgEnabled = !empty(($cs['website_body'] ?? [])['enabled'] ?? false);
    @endphp
    <div class="min-h-screen {{ !$bodyBgEnabled ? 'bg-slate-50 dark:bg-slate-950' : 'website-body-override' }}">
        <!-- Header -->
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-cyan-950 dark:from-slate-900 dark:via-slate-950 dark:to-cyan-950 text-white">
            <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;" aria-hidden="true"></div>
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <a href="{{ route('website.home') }}" 
                   class="inline-flex items-center gap-2 text-cyan-400/90 hover:text-white transition-colors mb-6">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Back to Home
                </a>
                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">{{ $website->name }}</h1>
                <p class="text-xl text-slate-300 mt-2">Menu</p>
            </div>
        </div>

        <!-- Menu Items by Category -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            @forelse($menuItems as $category => $items)
                <div class="mb-16 last:mb-0">
                    @if($category)
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">{{ $category }}</h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            <div class="group bg-white dark:bg-slate-900/80 rounded-xl overflow-hidden ring-1 ring-slate-200/60 dark:ring-slate-700/50 hover:ring-cyan-500/50 dark:hover:ring-cyan-500/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-slate-900/50">
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
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-32 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                                        <svg class="h-10 w-10 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="flex justify-between items-start gap-4 mb-2">
                                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">{{ $item->name }}</h3>
                                        <span class="text-xl font-bold text-cyan-600 dark:text-cyan-400 shrink-0">
                                            ${{ number_format($item->price, 2) }}
                                        </span>
                                    </div>
                                    @if($item->description)
                                        <p class="text-slate-600 dark:text-slate-400 mb-4">{{ $item->description }}</p>
                                    @endif
                                    @if($item->dietary_info && is_array($item->dietary_info) && count($item->dietary_info) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item->dietary_info as $dietary)
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                                                    {{ ucfirst($dietary) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!$item->is_available)
                                        <span class="inline-block mt-3 px-3 py-1.5 text-sm font-semibold rounded-lg bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">
                                            Currently Unavailable
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mb-6">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <p class="text-xl text-slate-600 dark:text-slate-400">No menu items available at this time.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-website-layout>
