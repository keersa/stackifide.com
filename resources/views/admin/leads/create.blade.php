<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Lead') }}
            </h2>
            <a href="{{ route('admin.leads.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Leads
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.leads.store') }}" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="restaurant_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Restaurant Name *</label>
                                <input type="text" 
                                       name="restaurant_name" 
                                       id="restaurant_name"
                                       value="{{ old('restaurant_name') }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @error('restaurant_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="business_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Type</label>
                                <input type="text" 
                                       name="business_type" 
                                       id="business_type"
                                       value="{{ old('business_type') }}"
                                       placeholder="e.g., Restaurant, Cafe, Bar"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="cuisine_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cuisine Type</label>
                                <input type="text" 
                                       name="cuisine_type" 
                                       id="cuisine_type"
                                       value="{{ old('cuisine_type') }}"
                                       placeholder="e.g., Italian, Mexican, Asian"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="number_of_locations" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Locations</label>
                                <input type="number" 
                                       name="number_of_locations" 
                                       id="number_of_locations"
                                       value="{{ old('number_of_locations') }}"
                                       min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name</label>
                                <input type="text" 
                                       name="contact_first_name" 
                                       id="contact_first_name"
                                       value="{{ old('contact_first_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="contact_last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name</label>
                                <input type="text" 
                                       name="contact_last_name" 
                                       id="contact_last_name"
                                       value="{{ old('contact_last_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ old('email') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone"
                                       value="{{ old('phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="secondary_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Secondary Phone</label>
                                <input type="text" 
                                       name="secondary_phone" 
                                       id="secondary_phone"
                                       value="{{ old('secondary_phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Address Information (Optional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="street_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street Address</label>
                                <input type="text" 
                                       name="street_address" 
                                       id="street_address"
                                       value="{{ old('street_address') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                <input type="text" 
                                       name="city" 
                                       id="city"
                                       value="{{ old('city') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                                <input type="text" 
                                       name="state" 
                                       id="state"
                                       value="{{ old('state') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                                <input type="text" 
                                       name="postal_code" 
                                       id="postal_code"
                                       value="{{ old('postal_code') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                <input type="text" 
                                       name="country" 
                                       id="country"
                                       value="{{ old('country', 'United States') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Details -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="current_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Website URL</label>
                                <input type="url" 
                                       name="current_url" 
                                       id="current_url"
                                       value="{{ old('current_url') }}"
                                       placeholder="https://example.com"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="current_ordering_system" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Ordering System</label>
                                <select name="current_ordering_system" 
                                        id="current_ordering_system"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select an option</option>
                                    <option value="GrubHub" {{ old('current_ordering_system') === 'GrubHub' ? 'selected' : '' }}>GrubHub</option>
                                    <option value="DoorDash" {{ old('current_ordering_system') === 'DoorDash' ? 'selected' : '' }}>DoorDash</option>
                                    <option value="Custom" {{ old('current_ordering_system') === 'Custom' ? 'selected' : '' }}>Custom</option>
                                    <option value="Other" {{ old('current_ordering_system') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="special_requirements" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requirements</label>
                                <textarea name="special_requirements" 
                                          id="special_requirements"
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('special_requirements') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lead Management -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lead Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                                <select name="status" 
                                        id="status"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="new" {{ old('status') === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="contacted" {{ old('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="qualified" {{ old('status') === 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="proposal" {{ old('status') === 'proposal' ? 'selected' : '' }}>Proposal</option>
                                    <option value="negotiation" {{ old('status') === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                    <option value="won" {{ old('status') === 'won' ? 'selected' : '' }}>Won</option>
                                    <option value="lost" {{ old('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </div>
                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Source</label>
                                <select name="source" 
                                        id="source"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select Source</option>
                                    <option value="website" {{ old('source') === 'website' ? 'selected' : '' }}>Website</option>
                                    <option value="referral" {{ old('source') === 'referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="social_media" {{ old('source') === 'social_media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="cold_call" {{ old('source') === 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                                    <option value="email" {{ old('source') === 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="other" {{ old('source') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="estimated_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Value ($)</label>
                                <input type="number" 
                                       name="estimated_value" 
                                       id="estimated_value"
                                       value="{{ old('estimated_value') }}"
                                       step="0.01"
                                       min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign To</label>
                                <select name="assigned_to" 
                                        id="assigned_to"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="first_contact_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Contact Date</label>
                                <input type="date" 
                                       name="first_contact_date" 
                                       id="first_contact_date"
                                       value="{{ old('first_contact_date', now()->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow Up Date</label>
                                <input type="date" 
                                       name="follow_up_date" 
                                       id="follow_up_date"
                                       value="{{ old('follow_up_date') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                                <input type="text" 
                                       name="tags" 
                                       id="tags"
                                       value="{{ old('tags', is_array(old('tags')) ? implode(', ', old('tags')) : '') }}"
                                       placeholder="Enter tags separated by commas (e.g., VIP, Follow-up, Hot Lead)"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <p class="mt-1 text-sm text-gray-500">Separate multiple tags with commas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Notes</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Public Notes</label>
                                <textarea name="notes" 
                                          id="notes"
                                          rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('notes') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">These notes can be shared with the client.</p>
                            </div>
                            <div>
                                <label for="internal_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Notes</label>
                                <textarea name="internal_notes" 
                                          id="internal_notes"
                                          rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('internal_notes') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Private notes - not visible to clients.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.leads.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Create Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

