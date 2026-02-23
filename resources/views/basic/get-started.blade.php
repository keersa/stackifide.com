<x-app-layout>
    <x-slot name="header">
        <div class="hidden">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Get Started - Basic Plan') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 dark:from-gray-900 dark:via-blue-900 dark:to-gray-900">
        <div class="py-8 md:py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-lg dark:bg-green-900 dark:border-green-400 dark:text-green-200" role="alert">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Hero Section -->
                <div class="text-center mb-8 md:mb-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-4 shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-3">
                        Get Started with Basic Plan
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        Tell us about your restaurant and we'll help you create an amazing online presence
                    </p>
                </div>

                <form method="POST" action="{{ route('basic.store') }}" class="space-y-6 md:space-y-8">
                    @csrf

                    <!-- Restaurant Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transform transition-all hover:shadow-2xl">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-xl font-bold text-white">Restaurant Information</h3>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div class="md:col-span-2">
                                    <label for="restaurant_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Restaurant Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="restaurant_name" 
                                               id="restaurant_name"
                                               value="{{ old('restaurant_name') }}"
                                               required
                                               placeholder="Enter your restaurant name"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all">
                                    </div>
                                    @error('restaurant_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="business_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Business Type</label>
                                    <div class="relative">
                                        <select name="business_type" 
                                                id="business_type"
                                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white appearance-none bg-white dark:bg-gray-700 transition-all">
                                            <option value="">Select business type...</option>
                                            <option value="Restaurant" {{ old('business_type') === 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                            <option value="Cafe" {{ old('business_type') === 'Cafe' ? 'selected' : '' }}>Cafe</option>
                                            <option value="Bar" {{ old('business_type') === 'Bar' ? 'selected' : '' }}>Bar</option>
                                            <option value="Food Truck" {{ old('business_type') === 'Food Truck' ? 'selected' : '' }}>Food Truck</option>
                                            <option value="Catering" {{ old('business_type') === 'Catering' ? 'selected' : '' }}>Catering</option>
                                            <option value="Bakery" {{ old('business_type') === 'Bakery' ? 'selected' : '' }}>Bakery</option>
                                            <option value="Other" {{ old('business_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="cuisine_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cuisine Type</label>
                                    <input type="text" 
                                           name="cuisine_type" 
                                           id="cuisine_type"
                                           value="{{ old('cuisine_type') }}"
                                           placeholder="e.g., Italian, Mexican, American"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                                <div>
                                    <label for="number_of_locations" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Number of Locations</label>
                                    <input type="number" 
                                           name="number_of_locations" 
                                           id="number_of_locations"
                                           value="{{ old('number_of_locations', 1) }}"
                                           min="1"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transform transition-all hover:shadow-2xl">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-xl font-bold text-white">Contact Information</h3>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div>
                                    <label for="contact_first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="contact_first_name" 
                                           id="contact_first_name"
                                           value="{{ old('contact_first_name') }}"
                                           required
                                           placeholder="John"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all">
                                    @error('contact_first_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="contact_last_name" 
                                           id="contact_last_name"
                                           value="{{ old('contact_last_name') }}"
                                           required
                                           placeholder="Doe"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all">
                                    @error('contact_last_name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input type="email" 
                                               name="email" 
                                               id="email"
                                               value="{{ old('email') }}"
                                               required
                                               placeholder="john@example.com"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all">
                                    </div>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <input type="tel" 
                                               name="phone" 
                                               id="phone"
                                               value="{{ old('phone') }}"
                                               required
                                               pattern="\(\d{3}\) \d{3}-\d{4}"
                                               placeholder="(555) 123-4567"
                                               maxlength="14"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all"
                                               autocomplete="tel">
                                    </div>
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transform transition-all hover:shadow-2xl">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-xl font-bold text-white">Location Information <span class="text-sm font-normal opacity-90">(Optional)</span></h3>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div class="md:col-span-2">
                                    <label for="street_address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Street Address</label>
                                    <input type="text" 
                                           name="street_address" 
                                           id="street_address"
                                           value="{{ old('street_address') }}"
                                           placeholder="123 Main Street"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">City</label>
                                    <input type="text" 
                                           name="city" 
                                           id="city"
                                           value="{{ old('city') }}"
                                           placeholder="New York"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">State</label>
                                    <input type="text" 
                                           name="state" 
                                           id="state"
                                           value="{{ old('state') }}"
                                           placeholder="NY"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Postal Code</label>
                                    <input type="text" 
                                           name="postal_code" 
                                           id="postal_code"
                                           value="{{ old('postal_code') }}"
                                           placeholder="10001"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                    <input type="text" 
                                           name="country" 
                                           id="country"
                                           value="{{ old('country', 'United States') }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Website & Ordering -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transform transition-all hover:shadow-2xl">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-xl font-bold text-white">Current Website & Ordering System</h3>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                                <div>
                                    <label for="current_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Current Website URL (if any)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </div>
                                        <input type="url" 
                                               name="current_url" 
                                               id="current_url"
                                               value="{{ old('current_url') }}"
                                               placeholder="https://yourrestaurant.com"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label for="current_ordering_system" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Current Ordering System</label>
                                    <div class="relative">
                                        <select name="current_ordering_system" 
                                                id="current_ordering_system"
                                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white appearance-none bg-white dark:bg-gray-700 transition-all">
                                            <option value="">None / Not sure</option>
                                            <option value="GrubHub" {{ old('current_ordering_system') === 'GrubHub' ? 'selected' : '' }}>GrubHub</option>
                                            <option value="DoorDash" {{ old('current_ordering_system') === 'DoorDash' ? 'selected' : '' }}>DoorDash</option>
                                            <option value="Custom" {{ old('current_ordering_system') === 'Custom' ? 'selected' : '' }}>Custom</option>
                                            <option value="Other" {{ old('current_ordering_system') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 transform transition-all hover:shadow-2xl">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-xl font-bold text-white">Additional Information</h3>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="space-y-5 md:space-y-6">
                                <div>
                                    <label for="special_requirements" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Special Requirements or Features Needed</label>
                                    <textarea name="special_requirements" 
                                              id="special_requirements"
                                              rows="4"
                                              placeholder="Tell us about any specific features, integrations, or requirements you have..."
                                              class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all resize-none">{{ old('special_requirements') }}</textarea>
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Additional Notes or Questions</label>
                                    <textarea name="notes" 
                                              id="notes"
                                              rows="4"
                                              placeholder="Any other information you'd like to share..."
                                              class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all resize-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-white">
                                <p class="text-lg font-semibold mb-1">Ready to get started?</p>
                                <p class="text-sm text-indigo-100">We'll review your information and contact you within 24 hours.</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                <a href="{{ url('/') }}" 
                                   class="inline-flex justify-center items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg border border-white/30 transition-all duration-200 transform hover:scale-105">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex justify-center items-center px-8 py-3 bg-white text-indigo-600 hover:bg-indigo-50 font-bold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 hover:shadow-xl">
                                    <span>Submit Inquiry</span>
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var phone = document.getElementById('phone');
            if (!phone) return;
            function formatPhone(value) {
                var digits = (value || '').replace(/\D/g, '').slice(0, 10);
                if (digits.length <= 3) return digits.length ? '(' + digits : '';
                if (digits.length <= 6) return '(' + digits.slice(0, 3) + ') ' + digits.slice(3);
                return '(' + digits.slice(0, 3) + ') ' + digits.slice(3, 6) + '-' + digits.slice(6);
            }
            function onPhoneInput() {
                var start = phone.selectionStart, oldLen = phone.value.length;
                phone.value = formatPhone(phone.value);
                var newLen = phone.value.length;
                phone.setSelectionRange(Math.max(0, start + (newLen - oldLen)), Math.max(0, start + (newLen - oldLen)));
            }
            phone.addEventListener('input', onPhoneInput);
            if (phone.value) onPhoneInput();
        })();
    </script>
</x-app-layout>
