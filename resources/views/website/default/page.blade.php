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
                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight">{{ $page->title }}</h1>
            </div>
        </div>

        <!-- Page Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="relative bg-white dark:bg-slate-900 rounded-2xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 dark:shadow-none ring-1 ring-slate-200/60 dark:ring-slate-700/50 overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-cyan-500 to-cyan-600 rounded-l-2xl" aria-hidden="true"></div>
                <div class="pl-4 sm:pl-6 prose-headings:text-slate-900 dark:prose-headings:text-white prose-p:text-slate-700 dark:prose-p:text-slate-300 prose-a:text-cyan-600 dark:prose-a:text-cyan-400 prose-a:no-underline hover:prose-a:underline">
                    @include('website.partials.page-content', ['page' => $page])
                </div>
            </div>
        </div>
    </div>
</x-website-layout>
