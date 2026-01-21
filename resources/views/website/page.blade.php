<x-website-layout>
    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-800 dark:to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h1 class="text-4xl font-bold mb-2">{{ $page->title }}</h1>
                <a href="{{ route('website.home') }}" 
                   class="text-purple-200 hover:text-white transition">
                    ← Back to Home
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-lg shadow-md p-8">
                <div class="prose dark:prose-invert max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
