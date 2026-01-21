<x-website-layout>
    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-800 dark:to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $website->name }}</h1>
                    @if($website->description)
                        <p class="text-xl md:text-2xl mb-8">{{ $website->description }}</p>
                    @endif
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('website.menu') }}" 
                           class="bg-white text-purple-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition">
                            View Menu
                        </a>
                        @if($website->contact_info && isset($website->contact_info['phone']))
                            <a href="tel:{{ $website->contact_info['phone'] }}" 
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Contact Us</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if(isset($website->contact_info['phone']))
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Phone</h3>
                                <a href="tel:{{ $website->contact_info['phone'] }}" 
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
                        @if(isset($website->contact_info['address']))
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Address</h3>
                                <p class="text-gray-700 dark:text-gray-300">{{ $website->contact_info['address'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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
                                <img src="{{ asset('storage/' . $item->image) }}" 
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
    </div>
</x-website-layout>
