<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    Upgrade Your Website
                </h1>
                <p class="text-xl lg:text-2xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Upgrade your website to get more features and grow your business.
                </p>
            </div>
        </div>
    </div>

    <!-- Website Builder Section -->
    <div class="py-16 lg:py-24 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        Website Builder
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Build a Professional Site in Minutes
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        Our intuitive website builder is designed specifically for restaurants. Add your menu, photos, hours, and contact info through a simple dashboard—no technical skills needed.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        Choose from modern templates, customize colors and branding, and publish your site in under an hour. Your website is automatically mobile-friendly, fast, and ready to attract customers.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Simple drag-and-drop menu management
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Beautiful templates built for restaurants
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Update your menu and hours anytime
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-8 shadow-xl">
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-indigo-500 dark:bg-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Design Without the Hassle</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Pre-built themes and customization options—no designer or developer required.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Go Live Fast</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Get your website online quickly with our streamlined setup process.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-purple-500 dark:bg-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Mobile-First</h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">Every site looks great on phones and tablets—where most customers browse.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ease of Use Section -->
    <div class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Built for Simplicity
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    No coding. No headaches. Just a straightforward dashboard that lets you manage your restaurant's online presence with ease.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Quick Setup</h3>
                    <p class="text-gray-600 dark:text-gray-300">Add your restaurant details, upload your menu, and publish. Most sites are live within an hour.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Easy Updates</h3>
                    <p class="text-gray-600 dark:text-gray-300">Change your menu, hours, or specials anytime. No waiting on a developer or paying for edits.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Hassle-Free Hosting</h3>
                    <p class="text-gray-600 dark:text-gray-300">We handle hosting, security, and backups. You focus on running your restaurant.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Section -->
    <div class="py-16 lg:py-24 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-block bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        Search Engine Optimization
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Get Found When Customers Search
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        When someone searches "best pizza near me" or "restaurants in [your city]," you want to show up. Stackifide builds SEO into every page.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        Proper meta tags, clean URLs, fast loading, and structured data help Google and other search engines understand and rank your site. No SEO plugins or technical setup—it's built in.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Optimized meta titles and descriptions
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Schema markup for local businesses
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Fast-loading pages (Google loves speed)
                        </li>
                    </ul>
                </div>
                <div class="order-1 lg:order-2 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-8 shadow-xl">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-900/50 mb-4">
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Built for Search</p>
                        <p class="text-gray-600 dark:text-gray-300">Every site is optimized out of the box—no extra setup required.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maps Section -->
    <div class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Be Easy to Find on Maps
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    When customers search for you on Google Maps or Apple Maps, they need the right info. Stackifide makes sure your address, hours, phone number, and website are consistent and discoverable.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow flex items-start gap-6">
                    <div class="flex-shrink-0 w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Google Maps Ready</h3>
                        <p class="text-gray-600 dark:text-gray-300">Proper address formatting and structured data help your listing appear when people search nearby. Your website can even embed a map so customers can get directions instantly.</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg hover:shadow-xl transition-shadow flex items-start gap-6">
                    <div class="flex-shrink-0 w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Apple Maps Too</h3>
                        <p class="text-gray-600 dark:text-gray-300">The same clean, structured contact info works for Apple Maps and other local search services. One source of truth for your address, hours, and contact details.</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Add your address and store hours once in Stackifide—and your website, SEO, and map listings stay in sync.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 lg:py-24 bg-gradient-to-br from-indigo-600 to-blue-600 dark:from-gray-800 dark:to-gray-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Ready to Grow Your Restaurant's Online Presence?
            </h2>
            <p class="text-xl text-indigo-50 dark:text-gray-200 mb-8">
                Create a professional website, get found on Google, and show up on maps—all with a platform built for restaurants.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('basic.get-started') }}" class="inline-block bg-white text-indigo-600 dark:bg-gray-800 dark:text-indigo-400 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all hover:scale-105">
                    Get Started
                </a>
                <a href="{{ route('contact.index') }}" class="inline-block bg-transparent border-2 border-white text-white dark:border-gray-300 dark:text-gray-200 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-indigo-600 dark:hover:bg-gray-700 transition-all">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
