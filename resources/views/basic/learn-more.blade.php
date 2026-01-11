<x-app-layout>
    <x-slot name="header">
        <div class="hidden">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Learn More - Basic Plan') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 dark:from-gray-900 dark:via-blue-900 dark:to-gray-900">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Basic Plan</h1>
                    <p class="text-xl md:text-2xl text-indigo-100 mb-6">Everything you need to establish your restaurant's online presence</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                            <p class="text-sm text-indigo-200">Starting at</p>
                            <p class="text-3xl font-bold">$199<span class="text-lg">/month</span></p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                            <p class="text-sm text-indigo-200">One-time Setup</p>
                            <p class="text-3xl font-bold">$199</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 md:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Overview -->
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Complete Website Solution</h2>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Our Basic plan provides everything you need to create a professional online presence for your restaurant. 
                        From a custom-designed website to powerful management tools, we've got you covered.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="space-y-8 md:space-y-12">
                    <!-- Custom Website -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex">
                            <div class="md:w-1/3 bg-gradient-to-br from-blue-500 to-indigo-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Custom Website</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Custom Website</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Get a professionally designed website tailored specifically to your restaurant's brand and style. 
                                    We work with you to create a unique online presence that reflects your restaurant's personality.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Responsive Design:</strong> Your website will look perfect on desktop, tablet, and mobile devices</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Custom Branding:</strong> We incorporate your logo, colors, and brand identity throughout the site</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>High-Quality Images:</strong> Professional photography integration for your menu items and restaurant</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Fast Loading:</strong> Optimized for speed to ensure your customers have a great experience</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Easy Navigation:</strong> Intuitive menu structure that helps customers find what they're looking for</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Hosting -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex md:flex-row-reverse">
                            <div class="md:w-1/3 bg-gradient-to-br from-green-500 to-emerald-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Hosting</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Reliable Hosting Included</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    No need to worry about finding a hosting provider or managing servers. We handle all the technical 
                                    aspects of hosting so you can focus on running your restaurant.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>99.9% Uptime Guarantee:</strong> Your website stays online, ensuring customers can always find you</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Automatic Backups:</strong> Daily backups protect your data and content</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>SSL Certificate:</strong> Secure HTTPS connection included for customer trust and SEO benefits</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Scalable Infrastructure:</strong> Handles traffic spikes during busy periods without slowdowns</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>24/7 Monitoring:</strong> We monitor your site around the clock to ensure optimal performance</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex">
                            <div class="md:w-1/3 bg-gradient-to-br from-purple-500 to-pink-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Analytics</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Powerful Analytics Dashboard</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Understand your customers better with comprehensive analytics. Track visitor behavior, popular pages, 
                                    and key metrics to make data-driven decisions for your restaurant.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Visitor Statistics:</strong> See how many people visit your site, when they visit, and where they come from</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Popular Pages:</strong> Discover which menu items or pages get the most attention</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Device Breakdown:</strong> Know if your customers browse on mobile, tablet, or desktop</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Traffic Sources:</strong> Understand how customers find you (search engines, social media, direct visits)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Monthly Reports:</strong> Receive easy-to-read reports summarizing your website's performance</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex md:flex-row-reverse">
                            <div class="md:w-1/3 bg-gradient-to-br from-cyan-500 to-blue-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">SEO</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Search Engine Optimization</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Get found by customers searching for restaurants in your area. Our SEO optimization helps your 
                                    restaurant appear in Google searches when people look for your cuisine type or location.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Local SEO:</strong> Optimized to appear in "near me" searches and local business listings</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Meta Tags & Descriptions:</strong> Properly optimized page titles and descriptions for search engines</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Structured Data:</strong> Rich snippets help your restaurant stand out in search results</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Mobile-Friendly:</strong> Google prioritizes mobile-optimized sites in search rankings</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Fast Page Speed:</strong> Optimized loading times improve both user experience and search rankings</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Integration -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex">
                            <div class="md:w-1/3 bg-gradient-to-br from-pink-500 to-rose-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.885 12.938 9 12.482 9 12c0-.482-.115-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Social Media</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Social Media Integration</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Connect your website with your social media presence. Share your latest posts, specials, and updates 
                                    directly on your website to keep customers engaged.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Social Feed Display:</strong> Show your latest Instagram or Facebook posts on your website</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Share Buttons:</strong> Easy sharing buttons so customers can share your menu and specials</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Social Login:</strong> Optional social media login for customer accounts</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Review Integration:</strong> Display your Yelp, Google, and Facebook reviews on your site</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Cross-Platform Promotion:</strong> Seamlessly link between your website and social profiles</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Management -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex md:flex-row-reverse">
                            <div class="md:w-1/3 bg-gradient-to-br from-orange-500 to-amber-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Menu Management</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Easy Menu Management System</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Update your menu anytime, anywhere with our user-friendly management system. No technical knowledge required— 
                                    simply log in and make changes to your menu items, prices, and descriptions.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Simple Admin Panel:</strong> Intuitive interface that makes updating your menu quick and easy</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Real-Time Updates:</strong> Changes appear on your website immediately—no waiting</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Image Upload:</strong> Add photos of your dishes to make your menu more appetizing</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Category Organization:</strong> Organize items by appetizers, entrees, desserts, drinks, etc.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Special Items:</strong> Highlight daily specials, seasonal items, or featured dishes</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Allergen Information:</strong> Add dietary information and allergen warnings to menu items</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Summary -->
                <div class="mt-12 md:mt-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl p-8 md:p-12 text-white">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Simple, Transparent Pricing</h2>
                        <p class="text-xl text-indigo-100">No hidden fees, no surprises</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.776 3.776c.03.242.066.477.098.717l3.464 3.464c.024-.137.048-.274.072-.412l2.341-2.341z"></path>
                                </svg>
                                <h3 class="text-2xl font-bold">Setup Fee</h3>
                            </div>
                            <p class="text-4xl font-bold mb-2">$199<span class="text-lg font-normal"> one-time</span></p>
                            <p class="text-indigo-100">Covers design, development, and initial setup</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-2xl font-bold">Monthly Fee</h3>
                            </div>
                            <p class="text-4xl font-bold mb-2">$199<span class="text-lg font-normal">/month</span></p>
                            <p class="text-indigo-100">Includes hosting, updates, and support</p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-12 md:mt-16 text-center">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Ready to Get Started?</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                            Fill out our quick survey and we'll get in touch within 24 hours to discuss your restaurant's needs.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('basic.get-started') }}" 
                               class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <span>Get Started Now</span>
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
