<x-app-layout>
    <x-slot name="header">
        <div class="hidden">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Learn More - Pro Plan') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-gray-900 dark:via-blue-900 dark:to-gray-900">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Pro Plan</h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-6">Advanced features for restaurants that need more</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                            <p class="text-sm text-blue-200">One-time Setup</p>
                            <p class="text-3xl font-bold">$189</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                            <p class="text-sm text-blue-200">Starting at</p>
                            <p class="text-3xl font-bold">$189<span class="text-lg">/month</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 md:py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Overview -->
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Advanced Website Solution</h2>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Our Pro plan includes everything from the Basic plan, plus advanced features like online ordering, 
                        reservation management, and premium support. Perfect for restaurants that need more functionality.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="space-y-8 md:space-y-12">
                    <!-- All Basic Features -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex">
                            <div class="md:w-1/3 bg-gradient-to-br from-blue-500 to-indigo-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Everything in Basic</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">All Basic Features Included</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    The Pro plan includes everything from our Basic plan: custom website, reliable hosting, 
                                    analytics dashboard, SEO optimization, social media integration, and easy menu management.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Custom website with responsive design</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>99.9% uptime hosting guarantee</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Comprehensive analytics dashboard</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>SEO optimization and local search</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Social media integration</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Easy menu management system</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Online Ordering -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex md:flex-row-reverse">
                            <div class="md:w-1/3 bg-gradient-to-br from-green-500 to-emerald-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Online Ordering</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Integrated Online Ordering</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Let customers place orders directly on your website. No need to redirect them to third-party 
                                    platforms—keep everything in one place and reduce commission fees.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Direct Ordering:</strong> Customers order directly from your website</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Pickup & Delivery:</strong> Support both pickup and delivery options</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Order Management:</strong> Track and manage orders from your dashboard</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Payment Processing:</strong> Secure payment processing integrated</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Reservation Management -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex">
                            <div class="md:w-1/3 bg-gradient-to-br from-purple-500 to-pink-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Reservations</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Reservation Management System</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Manage table reservations directly from your website. Customers can book tables online, 
                                    and you can manage availability, time slots, and special requests from one dashboard.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Online Booking:</strong> Customers can book tables directly from your site</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Availability Management:</strong> Set available time slots and table sizes</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Third-Party Integration:</strong> Connect with OpenTable, Resy, or similar platforms</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Guest Management:</strong> Track guest preferences and special requests</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Support -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="md:flex md:flex-row-reverse">
                            <div class="md:w-1/3 bg-gradient-to-br from-amber-500 to-orange-600 p-8 md:p-12 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4 inline-block">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">Premium Support</h3>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6 md:p-12">
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">Priority Support & Assistance</h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6 text-lg">
                                    Get faster response times and priority support when you need help. Our team is dedicated 
                                    to ensuring your website runs smoothly and helps grow your business.
                                </p>
                                <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Priority Response:</strong> Faster response times for support requests</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Phone Support:</strong> Direct phone line for urgent issues</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Strategic Guidance:</strong> Get advice on promotions, content, and growth</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Regular Check-ins:</strong> Proactive support and performance reviews</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Summary -->
                <div class="mt-12 md:mt-16 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl shadow-2xl p-8 md:p-12 text-white">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Custom Pricing for Your Needs</h2>
                        <p class="text-xl text-blue-100">Pro plan pricing is customized based on your specific requirements</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.776 3.776c.03.242.066.477.098.717l3.464 3.464c.024-.137.048-.274.072-.412l2.341-2.341z"></path>
                                </svg>
                                <h3 class="text-2xl font-bold">Setup Fee</h3>
                            </div>
                            <p class="text-4xl font-bold mb-2">Custom</p>
                            <p class="text-blue-100">Based on your specific requirements</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-2xl font-bold">Monthly Fee</h3>
                            </div>
                            <p class="text-4xl font-bold mb-2">Custom</p>
                            <p class="text-blue-100">Tailored to your feature set</p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-12 md:mt-16 text-center">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 md:p-12 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Ready to Get Started?</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                            Fill out our quick survey and we'll get in touch within 24 hours to discuss your restaurant's needs and create a custom Pro plan for you.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('pro.get-started') }}" 
                               class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
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
