<x-website-layout>
    <div class="min-h-screen bg-amber-50/50 dark:bg-gray-950 overflow-x-hidden">
        <!-- Header -->
        <div class="relative overflow-hidden min-h-[35vh] sm:min-h-[40vh] flex flex-col justify-center">
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
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white">{{ $page->title }}</h1>
            </div>
        </div>

        <!-- Page Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24">
            <article class="relative">
                <div class="absolute -left-2 sm:-left-4 top-0 w-0.5 sm:w-1 h-full bg-gradient-to-b from-amber-400 to-amber-600 dark:from-amber-600 dark:to-amber-800 rounded-full hidden md:block"></div>
                <div class="bg-white dark:bg-gray-800/90 rounded-2xl sm:rounded-3xl shadow-xl border border-amber-100/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-5 sm:p-6 lg:p-12">
                        <div class="prose prose-sm sm:prose-base lg:prose-lg dark:prose-invert max-w-none
                            prose-headings:font-display prose-headings:text-gray-900 dark:prose-headings:text-white
                            prose-headings:break-words
                            prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:break-words
                            prose-a:text-amber-600 dark:prose-a:text-amber-400 prose-a:no-underline hover:prose-a:underline prose-a:break-words
                            prose-strong:text-gray-900 dark:prose-strong:text-white
                            prose-ul:text-gray-700 dark:prose-ul:text-gray-300
                            prose-ol:text-gray-700 dark:prose-ol:text-gray-300
                            prose-blockquote:border-amber-500 prose-blockquote:bg-amber-50/50 dark:prose-blockquote:bg-amber-900/10 dark:prose-blockquote:border-amber-600
                            prose-img:rounded-xl prose-img:w-full prose-img:h-auto
                            prose-pre:overflow-x-auto prose-pre:text-sm">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-website-layout>
