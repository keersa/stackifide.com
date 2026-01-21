<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Page Details') }} - {{ $website->name }}</span>
            <div class="flex gap-2">
                <a href="{{ route('admin.websites.pages.edit', [$website, $page]) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.websites.pages.index', $website) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Pages
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $page->title }}</h2>
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Slug</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->slug }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <span class="mt-1 inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $page->is_published ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                            {{ $page->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    @if($page->meta_title)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Meta Title</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->meta_title }}</p>
                        </div>
                    @endif
                    @if($page->meta_description)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Meta Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->meta_description }}</p>
                        </div>
                    @endif
                </div>
                @if($page->content)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Content</label>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $page->content !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
