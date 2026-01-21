<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
                <span>{{ __('Lead Details') }}</span>
            <div class="flex space-x-2">
                <a href="{{ route('super-admin.leads.edit', $lead) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('super-admin.leads.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Leads
                </a>
            </div>
        </div>
    </x-slot>

    <div>
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Restaurant Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->restaurant_name }}</dd>
                                </div>
                                @if($lead->business_type)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Business Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->business_type }}</dd>
                                    </div>
                                @endif
                                @if($lead->cuisine_type)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuisine Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->cuisine_type }}</dd>
                                    </div>
                                @endif
                                @if($lead->number_of_locations)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of Locations</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->number_of_locations }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($lead->contact_full_name)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->contact_full_name }}</dd>
                                    </div>
                                @endif
                                @if($lead->email)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="mailto:{{ $lead->email }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400">
                                                {{ $lead->email }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="tel:{{ $lead->phone }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400">
                                                {{ $lead->phone }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->secondary_phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Secondary Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="tel:{{ $lead->secondary_phone }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400">
                                                {{ $lead->secondary_phone }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Address Information -->
                    @if($lead->full_address)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Address</h3>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $lead->full_address }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Business Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Details</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($lead->current_url)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Website</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ $lead->current_url }}" target="_blank" class="text-purple-600 hover:text-purple-900 dark:text-purple-400">
                                                {{ $lead->current_url }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->current_ordering_system)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Ordering System</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $lead->current_ordering_system }}</dd>
                                    </div>
                                @endif
                                @if($lead->special_requirements)
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Special Requirements</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $lead->special_requirements }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($lead->notes)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Notes</h3>
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $lead->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Internal Notes -->
                    @if($lead->internal_notes)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Internal Notes</h3>
                                <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $lead->internal_notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lead Status</h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                        @if($lead->status === 'new') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($lead->status === 'contacted') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($lead->status === 'qualified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($lead->status === 'won') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($lead->status === 'lost') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </div>
                                @if($lead->source)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Source</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ ucfirst(str_replace('_', ' ', $lead->source)) }}
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->estimated_value)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Value</dt>
                                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            ${{ number_format($lead->estimated_value, 2) }}
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->assignedUser)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned To</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->assignedUser->full_name }}
                                        </dd>
                                    </div>
                                @endif
                                @php
                                    $tags = is_array($lead->tags) ? $lead->tags : (is_string($lead->tags) ? json_decode($lead->tags, true) : []);
                                    $tags = is_array($tags) ? array_filter($tags) : [];
                                @endphp
                                @if(!empty($tags))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tags</dt>
                                        <dd class="mt-1 flex flex-wrap gap-2">
                                            @foreach($tags as $tag)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Timeline</h3>
                            <dl class="space-y-4">
                                @if($lead->first_contact_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">First Contact</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->first_contact_date->format('M d, Y') }}
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->last_contact_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Contact</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->last_contact_date->format('M d, Y') }}
                                        </dd>
                                    </div>
                                @endif
                                @if($lead->follow_up_date)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Follow Up Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->follow_up_date->format('M d, Y') }}
                                            @if($lead->follow_up_date->isPast())
                                                <span class="text-red-600 dark:text-red-400">(Overdue)</span>
                                            @endif
                                        </dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $lead->created_at->format('M d, Y') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $lead->updated_at->format('M d, Y') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-super-admin-layout>

