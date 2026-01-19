<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 px-4 lg:px-0 mx-auto max-w-7xl text-center">
            <div class="relative bg-gray-100 dark:bg-gray-800 pt-8 pb-24 lg:pb-8 px-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">Basic</h2>
                <h3 class="text-2xl text-gray-800 dark:text-gray-200 mb-4">$199/month</h3>
                <div class="flex items-center justify-center gap-3 mb-6 bg-white dark:bg-gray-700 dark:border-gray-300 rounded-lg p-2 text-gray-700 dark:text-gray-300">
                    <svg class="w-5 h-5 text-green-500 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.776 3.776c.03.242.066.477.098.717l3.464 3.464c.024-.137.048-.274.072-.412l2.341-2.341z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.867 19.125h.008v.008h-.008v-.008z"></path>
                    </svg>
                    <span>One-time Setup Fee: $199</span>
                </div>
                <ul class="space-y-3 text-left mb-24">
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Custom Website</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Hosting</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Analytics</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Search Engine Optimization</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Social Media Integration</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Menu Management</span>
                    </li>
                </ul>
                <div class="absolute bottom-5 left-0 right-0 grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8 px-4">
                    <a href="{{ route('basic.learn-more') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Learn More
                    </a>
                    <a href="{{ route('basic.get-started') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Get Started
                    </a>
                </div>
            </div>
            <div class="relative bg-gray-100 dark:bg-gray-800 pt-8 pb-24 lg:pb-8 px-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">Pro</h2>
                <h3 class="text-2xl text-gray-800 dark:text-gray-200 mb-4">$299/month</h3>
                <div class="flex items-center justify-center gap-3 mb-6 bg-white dark:bg-gray-700 dark:border-gray-300 rounded-lg p-2 text-gray-700 dark:text-gray-300">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.776 3.776c.03.242.066.477.098.717l3.464 3.464c.024-.137.048-.274.072-.412l2.341-2.341z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.867 19.125h.008v.008h-.008v-.008z"></path>
                    </svg>
                    <span>One-time Setup Fee: $299</span>
                </div>
                <ul class="space-y-3 text-left mb-24">
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Custom Website</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Hosting</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Analytics</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Search Engine Optimization</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Social Media Integration</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Menu Management</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-700 rounded-md p-2">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Online Ordering</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-700 rounded-md p-2">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Email Marketing</span>
                    </li>
                </ul>
                <div class="absolute bottom-5 left-0 right-0 grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8 px-4">
                    <a href="{{ route('pro.learn-more') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Learn More
                    </a>
                    <a href="{{ route('pro.get-started') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Get Started
                    </a>
                </div>
                
            </div>

            <div class="relative bg-gray-100 dark:bg-gray-800 pt-8 pb-24 lg:pb-8 px-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">Custom Plan</h2>
                <h3 class="text-2xl text-gray-800 dark:text-gray-200 mb-4">TBD/month</h3>
                <div class="flex items-center justify-center gap-3 mb-6 bg-white dark:bg-gray-700 dark:border-gray-300 rounded-lg p-2 text-gray-700 dark:text-gray-300">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.776 3.776c.03.242.066.477.098.717l3.464 3.464c.024-.137.048-.274.072-.412l2.341-2.341z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.867 19.125h.008v.008h-.008v-.008z"></path>
                    </svg>
                    <span>One-time Setup Fee: $TBD</span>
                </div>
                <ul class="space-y-3 text-left mb-24">
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Custom Website</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Hosting</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Analytics</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Search Engine Optimization</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Social Media Integration</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Menu Management</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-700 rounded-md p-2">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Online Ordering</span>
                    </li>
                    <li class="flex items-start gap-3 text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-700 rounded-md p-2">
                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Email Marketing</span>
                    </li>
                </ul>
                <div class="absolute bottom-5 left-0 right-0 grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8 px-4">
                    <a href="{{ route('pro.learn-more') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Learn More
                    </a>
                    <a href="{{ route('pro.get-started') }}"  class="bg-white dark:bg-gray-700 p-4 text-xl font-black text-center rounded-xl border border-gray-800 dark:border-black text-black dark:text-white hover:shadow-lg transition-all hover:scale-105 duration-200">
                        Get Started
                    </a>
                </div>
                
            </div>
           
        </div>
    </div>
</x-app-layout>
    