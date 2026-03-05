<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Edit Lead') }}</span>
        </div>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('super-admin.leads.update', $lead) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="restaurant_name" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Restaurant Name *</label>
                                    <input type="text" name="restaurant_name" id="restaurant_name"
                                           value="{{ old('restaurant_name', $lead->restaurant_name) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('restaurant_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="business_type" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Business Type</label>
                                    <select name="business_type" id="business_type"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Select type</option>
                                        <option value="Restaurant" {{ old('business_type', $lead->business_type) === 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                        <option value="Food Truck" {{ old('business_type', $lead->business_type) === 'Food Truck' ? 'selected' : '' }}>Food Truck</option>
                                        <option value="Bar" {{ old('business_type', $lead->business_type) === 'Bar' ? 'selected' : '' }}>Bar</option>
                                        <option value="Other" {{ old('business_type', $lead->business_type) === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="cuisine_type" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cuisine Type</label>
                                    <input type="text" name="cuisine_type" id="cuisine_type"
                                           value="{{ old('cuisine_type', $lead->cuisine_type) }}"
                                           placeholder="e.g., Italian, Mexican, Asian"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                                    <label for="contact_first_name" class="block text-sm font-medium text-gray-500 dark:text-gray-400">First Name</label>
                                    <input type="text" name="contact_first_name" id="contact_first_name"
                                           value="{{ old('contact_first_name', $lead->contact_first_name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="contact_last_name" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</label>
                                    <input type="text" name="contact_last_name" id="contact_last_name"
                                           value="{{ old('contact_last_name', $lead->contact_last_name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                    <input type="email" name="email" id="email"
                                           value="{{ old('email', $lead->email) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                                    <input type="text" name="phone" id="phone"
                                           value="{{ old('phone', $lead->phone) }}"
                                           placeholder="(813) 333-3333"
                                           pattern="\(\d{3}\) \d{3}-\d{4}"
                                           maxlength="14"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="secondary_phone" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Secondary Phone</label>
                                    <input type="text" name="secondary_phone" id="secondary_phone"
                                           value="{{ old('secondary_phone', $lead->secondary_phone) }}"
                                           placeholder="(813) 333-3333"
                                           pattern="\(\d{3}\) \d{3}-\d{4}"
                                           maxlength="14"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('secondary_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Address Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="street_address" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Street Address</label>
                                    <input type="text" name="street_address" id="street_address"
                                           value="{{ old('street_address', $lead->street_address) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-500 dark:text-gray-400">City</label>
                                    <input type="text" name="city" id="city"
                                           value="{{ old('city', $lead->city) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-500 dark:text-gray-400">State</label>
                                    <input type="text" name="state" id="state"
                                           value="{{ old('state', $lead->state) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code"
                                           value="{{ old('postal_code', $lead->postal_code) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
                                    <input type="text" name="country" id="country"
                                           value="{{ old('country', $lead->country ?? 'United States') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
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
                                    <label for="current_url" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Current Website URL</label>
                                    <input type="url" name="current_url" id="current_url"
                                           value="{{ old('current_url', $lead->current_url) }}"
                                           placeholder="https://example.com"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="current_ordering_system" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Current Ordering System</label>
                                    <select name="current_ordering_system" id="current_ordering_system"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Select an option</option>
                                        <option value="GrubHub" {{ old('current_ordering_system', $lead->current_ordering_system) === 'GrubHub' ? 'selected' : '' }}>GrubHub</option>
                                        <option value="DoorDash" {{ old('current_ordering_system', $lead->current_ordering_system) === 'DoorDash' ? 'selected' : '' }}>DoorDash</option>
                                        <option value="Custom" {{ old('current_ordering_system', $lead->current_ordering_system) === 'Custom' ? 'selected' : '' }}>Custom</option>
                                        <option value="Other" {{ old('current_ordering_system', $lead->current_ordering_system) === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="facebook_url" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Facebook</label>
                                    <input type="url" name="facebook_url" id="facebook_url"
                                           value="{{ old('facebook_url', $lead->facebook_url) }}"
                                           placeholder="https://facebook.com/..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="instagram_url" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Instagram</label>
                                    <input type="url" name="instagram_url" id="instagram_url"
                                           value="{{ old('instagram_url', $lead->instagram_url) }}"
                                           placeholder="https://instagram.com/..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="yelp_url" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Yelp</label>
                                    <input type="url" name="yelp_url" id="yelp_url"
                                           value="{{ old('yelp_url', $lead->yelp_url) }}"
                                           placeholder="https://yelp.com/biz/..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="youtube_url" class="block text-sm font-medium text-gray-500 dark:text-gray-400">YouTube</label>
                                    <input type="url" name="youtube_url" id="youtube_url"
                                           value="{{ old('youtube_url', $lead->youtube_url) }}"
                                           placeholder="https://youtube.com/..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="special_requirements" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Special Requirements</label>
                                    <textarea name="special_requirements" id="special_requirements" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('special_requirements', $lead->special_requirements) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Internal Notes -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Internal Notes</h3>
                            <div>
                                <label for="internal_notes" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Internal Notes</label>
                                <textarea name="internal_notes" id="internal_notes" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('internal_notes', $lead->internal_notes) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Private notes - not visible to clients.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Lead Status / Management -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lead Status</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status *</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="new" {{ old('status', $lead->status) === 'new' ? 'selected' : '' }}>New</option>
                                        <option value="contacted" {{ old('status', $lead->status) === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="qualified" {{ old('status', $lead->status) === 'qualified' ? 'selected' : '' }}>Qualified</option>
                                        <option value="proposal" {{ old('status', $lead->status) === 'proposal' ? 'selected' : '' }}>Proposal</option>
                                        <option value="negotiation" {{ old('status', $lead->status) === 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                        <option value="won" {{ old('status', $lead->status) === 'won' ? 'selected' : '' }}>Won</option>
                                        <option value="lost" {{ old('status', $lead->status) === 'lost' ? 'selected' : '' }}>Lost</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="source" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Source</label>
                                    <select name="source" id="source"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Select Source</option>
                                        <option value="google_maps" {{ old('source', $lead->source) === 'google_maps' ? 'selected' : '' }}>Google Maps</option>
                                        <option value="website" {{ old('source', $lead->source) === 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="referral" {{ old('source', $lead->source) === 'referral' ? 'selected' : '' }}>Referral</option>
                                        <option value="social_media" {{ old('source', $lead->source) === 'social_media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="cold_call" {{ old('source', $lead->source) === 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                                        <option value="email" {{ old('source', $lead->source) === 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="other" {{ old('source', $lead->source) === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tags</label>
                                    <input type="text" name="tags" id="tags"
                                           value="{{ is_array(old('tags')) ? implode(', ', old('tags')) : old('tags', is_array($lead->tags) ? implode(', ', $lead->tags) : ($lead->tags ?? '')) }}"
                                           placeholder="Enter tags separated by commas"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <p class="mt-1 text-sm text-gray-500">Separate multiple tags with commas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Customer Contacts -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" id="customer-contacts-section">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Customer Contacts</h3>
                            

                            <!-- Contacts list -->
                            <ul id="contacts-list" class="">
                                @foreach($lead->prospectiveContacts as $contact)
                                    <li class="contact-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-2 bg-gray-50 dark:bg-gray-700/30" data-contact-id="{{ $contact->id }}">
                                        <div class="contact-display flex flex-wrap items-start justify-between gap-2">
                                            <div class="min-w-0 flex-1">
                                                <span class="text-gray-700 dark:text-gray-500 font-medium text-gray-900 dark:text-gray-100">{{ $contact->contact_type_label }}</span>
                        
                                                @if($contact->notes)
                                                    <p class="mt-1 text-md text-gray-700 dark:text-gray-300">{{ $contact->notes }}</p>
                                                @endif
                                                @if($contact->user)
                                                    <div>
                                                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Added by {{ $contact->user->full_name ?: $contact->user->email }} </div> 
                                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $contact->created_at->format('M j, Y g:i A') }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex gap-2 shrink-0">
                                                <button type="button" class="contact-edit-btn text-sm text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300">Edit</button>
                                                <button type="button" class="contact-delete-btn text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </div>
                                        </div>
                                        <div class="contact-edit-form hidden mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Contact type</label>
                                                    <select class="edit-contact-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                                                        @foreach($contactTypes as $value => $label)
                                                            <option value="{{ $value }}" {{ $contact->contact_type === $value ? 'selected' : '' }}>{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Notes</label>
                                                    <textarea class="edit-contact-notes mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" rows="2">{{ $contact->notes }}</textarea>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" class="contact-save-btn bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium py-1.5 px-3 rounded">Save</button>
                                                    <button type="button" class="contact-cancel-edit-btn text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <button type="button" id="toggle-add-contact-btn" class="mt-4 mb-4 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium py-2 px-4 rounded">
                                Add Customer Contact
                            </button>

                            <!-- Add new contact form (hidden by default) -->
                            <div id="add-contact-form-wrap" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hidden">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Add contact</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label for="new_contact_type" class="block text-xs font-medium text-gray-500 dark:text-gray-400">Contact type</label>
                                        <select id="new_contact_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                                            @foreach($contactTypes as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="new_contact_notes" class="block text-xs font-medium text-gray-500 dark:text-gray-400">Notes</label>
                                        <textarea id="new_contact_notes" rows="2" placeholder="Optional notes..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm"></textarea>
                                    </div>
                                    <button type="button" id="add-contact-btn" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium py-2 px-4 rounded">
                                        Add contact
                                    </button>
                                </div>
                                <p id="add-contact-error" class="mt-2 text-sm text-red-600 hidden"></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="text-center py-8 flex flex-wrap items-center justify-center gap-3">
                <button type="button" id="lead-delete-btn"
                        class="inline-block px-12 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded">
                    Delete
                </button>
                <button type="submit"
                        class="inline-block px-12 py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded">
                    Update Lead
                </button>
            </div>
        </form>
        <form id="lead-delete-form" action="{{ route('super-admin.leads.destroy', $lead) }}" method="post" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Delete lead confirmation modal -->
    <div id="delete-lead-modal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog" aria-labelledby="delete-lead-modal-title">
        <div class="fixed inset-0 bg-black/50 dark:bg-black/60" id="delete-lead-modal-backdrop"></div>
        <div class="fixed left-1/2 top-1/2 z-50 w-full max-w-sm -translate-x-1/2 -translate-y-1/2 rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800">
            <h3 id="delete-lead-modal-title" class="text-lg font-semibold text-gray-900 dark:text-gray-100">Delete lead?</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">This lead will be moved to the deleted list. It can be restored from the leads list if needed.</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="delete-lead-modal-cancel" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="button" id="delete-lead-modal-confirm" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var modal = document.getElementById('delete-lead-modal');
            var btn = document.getElementById('lead-delete-btn');
            var form = document.getElementById('lead-delete-form');
            var cancel = document.getElementById('delete-lead-modal-cancel');
            var confirmBtn = document.getElementById('delete-lead-modal-confirm');
            var backdrop = document.getElementById('delete-lead-modal-backdrop');
            if (!modal || !btn || !form) return;
            function openModal() { modal.classList.remove('hidden'); }
            function closeModal() { modal.classList.add('hidden'); }
            btn.addEventListener('click', openModal);
            cancel.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);
            confirmBtn.addEventListener('click', function() { form.submit(); });
        })();
    </script>

    <!-- Delete contact confirmation modal -->
    <div id="delete-contact-modal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog" aria-labelledby="delete-contact-modal-title">
        <div class="fixed inset-0 bg-black/50 dark:bg-black/60" id="delete-contact-modal-backdrop"></div>
        <div class="fixed left-1/2 top-1/2 z-50 w-full max-w-sm -translate-x-1/2 -translate-y-1/2 rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800">
            <h3 id="delete-contact-modal-title" class="text-lg font-semibold text-gray-900 dark:text-gray-100">Delete contact?</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">This contact will be removed from the log. This cannot be undone.</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="delete-contact-modal-cancel" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="button" id="delete-contact-modal-confirm" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        window.ProspectiveContactsConfig = {
            storeUrl: "{{ route('super-admin.leads.prospective-contacts.store', $lead) }}",
            csrfToken: "{{ csrf_token() }}",
            contactTypes: @json($contactTypes),
        };
    </script>
    <script>
        (function() {
            var config = window.ProspectiveContactsConfig;
            if (!config) return;

                function contactRowHtml(contact) {
                var typeOpts = '';
                for (var k in config.contactTypes) {
                    typeOpts += '<option value="' + k + '"' + (contact.contact_type === k ? ' selected' : '') + '>' + (config.contactTypes[k] || k) + '</option>';
                }
                var notesEsc = (contact.notes || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                var userNameEsc = (contact.user_name || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                return '<li class="contact-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700/30" data-contact-id="' + contact.id + '">' +
                    '<div class="contact-display flex flex-wrap items-start justify-between gap-2">' +
                    '<div class="min-w-0 flex-1">' +
                    '<span class="font-medium text-gray-900 dark:text-gray-100">' + (contact.contact_type_label || contact.contact_type) + '</span>' +
                    ' <span class="text-sm text-gray-500 dark:text-gray-400">' + (contact.created_at_human || '') + '</span>' +
                    (contact.notes ? '<p class="mt-1 text-sm text-gray-700 dark:text-gray-300">' + notesEsc + '</p>' : '') +
                    (contact.user_name ? '<p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Added by ' + userNameEsc + '</p>' : '') +
                    '</div>' +
                    '<div class="flex gap-2 shrink-0">' +
                    '<button type="button" class="contact-edit-btn text-sm text-purple-600 hover:text-purple-800 dark:text-purple-400">Edit</button>' +
                    '<button type="button" class="contact-delete-btn text-sm text-red-600 hover:text-red-800 dark:text-red-400">Delete</button>' +
                    '</div></div>' +
                    '<div class="contact-edit-form hidden mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">' +
                    '<div class="space-y-3"><div><label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Contact type</label>' +
                    '<select class="edit-contact-type mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">' + typeOpts + '</select></div>' +
                    '<div><label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Notes</label>' +
                    '<textarea class="edit-contact-notes mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm" rows="2">' + notesEsc + '</textarea></div>' +
                    '<div class="flex gap-2">' +
                    '<button type="button" class="contact-save-btn bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium py-1.5 px-3 rounded">Save</button>' +
                    '<button type="button" class="contact-cancel-edit-btn text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancel</button></div></div></div></li>';
            }

            function toggleEmptyMessage() {
                var list = document.getElementById('contacts-list');
                var empty = document.getElementById('contacts-empty');
                if (empty) empty.classList.toggle('hidden', list && list.children.length > 0);
            }

            var addFormWrap = document.getElementById('add-contact-form-wrap');
            var toggleAddBtn = document.getElementById('toggle-add-contact-btn');
            if (toggleAddBtn && addFormWrap) {
                toggleAddBtn.addEventListener('click', function() {
                    var isHidden = addFormWrap.classList.toggle('hidden');
                    toggleAddBtn.textContent = isHidden ? 'Add Customer Contact' : 'Cancel';
                });
            }

            var deleteModal = document.getElementById('delete-contact-modal');
            var deleteModalBackdrop = document.getElementById('delete-contact-modal-backdrop');
            var deleteModalCancel = document.getElementById('delete-contact-modal-cancel');
            var deleteModalConfirm = document.getElementById('delete-contact-modal-confirm');
            var pendingDeleteLi = null;
            var pendingDeleteId = null;

            function showDeleteModal(li, contactId) {
                pendingDeleteLi = li;
                pendingDeleteId = contactId;
                if (deleteModal) deleteModal.classList.remove('hidden');
            }

            function hideDeleteModal() {
                pendingDeleteLi = null;
                pendingDeleteId = null;
                if (deleteModal) deleteModal.classList.add('hidden');
            }

            function doDeleteContact() {
                if (!pendingDeleteLi || !pendingDeleteId) return;
                var li = pendingDeleteLi;
                var id = pendingDeleteId;
                hideDeleteModal();
                var deleteBtn = li.querySelector('.contact-delete-btn');
                if (deleteBtn) deleteBtn.disabled = true;
                fetch(config.storeUrl + '/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': config.csrfToken }
                }).then(function(r) {
                    if (!r.ok) throw new Error(r.statusText);
                    li.remove();
                    toggleEmptyMessage();
                }).catch(function() {
                    if (deleteBtn) deleteBtn.disabled = false;
                }).finally(function() {
                    if (deleteBtn) deleteBtn.disabled = false;
                });
            }

            if (deleteModalCancel) deleteModalCancel.addEventListener('click', hideDeleteModal);
            if (deleteModalConfirm) deleteModalConfirm.addEventListener('click', doDeleteContact);
            if (deleteModalBackdrop) deleteModalBackdrop.addEventListener('click', hideDeleteModal);
            if (deleteModal) deleteModal.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') hideDeleteModal();
            });

            // Add contact
            var addBtn = document.getElementById('add-contact-btn');
            var newType = document.getElementById('new_contact_type');
            var newNotes = document.getElementById('new_contact_notes');
            var addError = document.getElementById('add-contact-error');
            if (addBtn && newType && newNotes) {
                addBtn.addEventListener('click', function() {
                    addError.classList.add('hidden');
                    addError.textContent = '';
                    var type = newType.value;
                    var notes = (newNotes.value || '').trim();
                    addBtn.disabled = true;
                    fetch(config.storeUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': config.csrfToken },
                        body: JSON.stringify({ contact_type: type, notes: notes })
                    }).then(function(r) {
                        if (!r.ok) throw new Error(r.statusText);
                        return r.json();
                    }).then(function(data) {
                        var list = document.getElementById('contacts-list');
                        if (list) {
                            var wrap = document.createElement('div');
                            wrap.innerHTML = contactRowHtml(data.contact);
                            var newLi = wrap.firstElementChild;
                            if (newLi) {
                                list.insertBefore(newLi, list.firstChild);
                                bindContactItem(newLi);
                            }
                        }
                        newNotes.value = '';
                        toggleEmptyMessage();
                    }).catch(function(e) {
                        addError.textContent = e.message || 'Failed to add contact.';
                        addError.classList.remove('hidden');
                    }).finally(function() { addBtn.disabled = false; });
                });
            }

            function bindContactItem(li) {
                if (!li || !li.classList.contains('contact-item')) return;
                var id = li.getAttribute('data-contact-id');
                var display = li.querySelector('.contact-display');
                var editForm = li.querySelector('.contact-edit-form');
                var editBtn = li.querySelector('.contact-edit-btn');
                var cancelBtn = li.querySelector('.contact-cancel-edit-btn');
                var saveBtn = li.querySelector('.contact-save-btn');
                var deleteBtn = li.querySelector('.contact-delete-btn');
                var typeSelect = li.querySelector('.edit-contact-type');
                var notesTa = li.querySelector('.edit-contact-notes');

                function showEdit() { if (display) display.classList.add('hidden'); if (editForm) editForm.classList.remove('hidden'); }
                function showDisplay() { if (display) display.classList.remove('hidden'); if (editForm) editForm.classList.add('hidden'); }

                if (editBtn) editBtn.addEventListener('click', showEdit);
                if (cancelBtn) cancelBtn.addEventListener('click', showDisplay);

                if (saveBtn && typeSelect && notesTa) {
                    saveBtn.addEventListener('click', function() {
                        var type = typeSelect.value;
                        var notes = (notesTa.value || '').trim();
                        saveBtn.disabled = true;
                        fetch(config.storeUrl + '/' + id, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': config.csrfToken },
                            body: JSON.stringify({ contact_type: type, notes: notes })
                        }).then(function(r) {
                            if (!r.ok) throw new Error(r.statusText);
                            return r.json();
                        }).then(function(data) {
                            var wrap = document.createElement('div');
                            wrap.innerHTML = contactRowHtml(data.contact);
                            var newEl = wrap.firstElementChild;
                            if (newEl && li.parentNode) {
                                li.parentNode.replaceChild(newEl, li);
                                bindContactItem(newEl);
                            }
                        }).catch(function() { saveBtn.disabled = false; }).finally(function() { saveBtn.disabled = false; });
                    });
                }

                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        showDeleteModal(li, id);
                    });
                }
            }

            document.querySelectorAll('#contacts-list .contact-item').forEach(bindContactItem);
        })();
    </script>
    <script>
        (function() {
            function formatPhone(value) {
                var digits = (value || '').replace(/\D/g, '').slice(0, 10);
                if (digits.length <= 3) return digits.length ? '(' + digits : '';
                if (digits.length <= 6) return '(' + digits.slice(0, 3) + ') ' + digits.slice(3);
                return '(' + digits.slice(0, 3) + ') ' + digits.slice(3, 6) + '-' + digits.slice(6);
            }
            function bindPhone(input) {
                if (!input) return;
                function onInput() {
                    var start = input.selectionStart, oldLen = input.value.length;
                    input.value = formatPhone(input.value);
                    var newLen = input.value.length;
                    input.setSelectionRange(Math.max(0, start + (newLen - oldLen)), Math.max(0, start + (newLen - oldLen)));
                }
                input.addEventListener('input', onInput);
                if (input.value) onInput();
            }
            bindPhone(document.getElementById('phone'));
            bindPhone(document.getElementById('secondary_phone'));
        })();
    </script>
</x-super-admin-layout>
