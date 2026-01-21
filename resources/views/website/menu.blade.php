<x-website-layout>
    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-800 dark:to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h1 class="text-4xl font-bold mb-2">{{ $website->name }} - Menu</h1>
                <a href="{{ route('website.home') }}" 
                   class="text-purple-200 hover:text-white transition">
                    ← Back to Home
                </a>
            </div>
        </div>

        <!-- Menu Items by Category -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @forelse($menuItems as $category => $items)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 border-b-2 border-purple-600 dark:border-purple-400 pb-2">
                        {{ $category }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($items as $item)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->name }}" 
                                         class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                                        <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                            ${{ number_format($item->price, 2) }}
                                        </span>
                                    </div>
                                    @if($item->description)
                                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $item->description }}</p>
                                    @endif
                                    @if($item->dietary_info && is_array($item->dietary_info) && count($item->dietary_info) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($item->dietary_info as $dietary)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ ucfirst($dietary) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!$item->is_available)
                                        <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Currently Unavailable
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-xl text-gray-600 dark:text-gray-400">No menu items available at this time.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-website-layout>
