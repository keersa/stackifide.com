@php
    $createInitialRows = [];
    $createContentSource = old('content');
    if ($createContentSource) {
        $decoded = json_decode($createContentSource, true);
        if (is_array($decoded) && isset($decoded['rows']) && is_array($decoded['rows'])) {
            $createInitialRows = $decoded['rows'];
        }
    }
@endphp

<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>
    @endpush
    <style>[x-cloak] { display: none !important; }</style>
    <x-admin-website-header :website="$website" title="Create Page" />

    <div class="py-2">
        <div class="px-2 pb-4 flex items-center justify-between">
            <h3 class="font-black text-gray-900 dark:text-white text-2xl tracking-tighter">{{ __('Manage Pages') }}</h3>
        </div>
        <form method="POST" action="{{ route('admin.websites.pages.store', $website) }}">
            @csrf

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Page Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title"
                                   value="{{ old('title') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                            <input type="text" 
                                   name="slug" 
                                   id="slug"
                                   value="{{ old('slug') }}"
                                   placeholder="Auto-generated from title if left empty"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
                        </div>
                        @include('admin.websites.pages.partials.row-editor', [
                            'initialRows' => $createInitialRows,
                            'uploadUrl' => route('admin.websites.pages.upload-image', $website),
                            'csrf' => csrf_token(),
                        ])
                        <div x-data="{ metaOpen: false }" class="space-y-4">
                            <button type="button"
                                    @click="metaOpen = !metaOpen"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md transition-colors">
                                <span>Meta Data</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': metaOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="metaOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 x-cloak
                                 class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                        <input type="text" 
                                               name="meta_title" 
                                               id="meta_title"
                                               value="{{ old('meta_title') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                        <input type="number" 
                                               name="sort_order" 
                                               id="sort_order"
                                               value="{{ old('sort_order', 0) }}"
                                               min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                                    <textarea name="meta_description" 
                                              id="meta_description"
                                              rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_published" 
                                   id="is_published"
                                   value="1"
                                   {{ old('is_published', false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <label for="is_published" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Published
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.websites.pages.index', $website) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Create Page
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
