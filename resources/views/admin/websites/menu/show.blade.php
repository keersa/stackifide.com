<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Menu Item Details') }} - {{ $website->name }}</span>
            <div class="flex gap-2">
                <a href="{{ route('admin.websites.menu.edit', [$website, $menuItem]) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.websites.menu.index', $website) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Menu
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        @if($menuItem->image)
                            @php
                                $imageUrl = null;
                                if (is_string($menuItem->image) && (str_starts_with($menuItem->image, 'http://') || str_starts_with($menuItem->image, 'https://'))) {
                                    $imageUrl = $menuItem->image;
                                } else {
                                    try {
                                        $imageUrl = '/storage/' . ltrim($menuItem->image, '/');
                                    } catch (\Throwable $e) {
                                        $imageUrl = asset('storage/' . $menuItem->image);
                                    }
                                }
                            @endphp
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $menuItem->name }}"
                                 class="w-full h-64 object-cover rounded-lg mb-4">
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $menuItem->name }}</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Price</label>
                                <p class="mt-1 text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($menuItem->price, 2) }}</p>
                            </div>
                            @if($menuItem->category)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $menuItem->category }}</p>
                                </div>
                            @endif
                            @if($menuItem->description)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $menuItem->description }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                                <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $menuItem->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $menuItem->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                            @if($menuItem->dietary_info && is_array($menuItem->dietary_info) && count($menuItem->dietary_info) > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Dietary Information</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($menuItem->dietary_info as $dietary)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                {{ ucfirst(str_replace('-', ' ', $dietary)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
