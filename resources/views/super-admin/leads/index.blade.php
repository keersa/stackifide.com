<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Leads Management') }}</span>
            <a href="{{ route('super-admin.leads.map') }}"
               title="Map view"
               class="inline-flex items-center justify-center w-9 h-9 rounded-md text-purple-600 hover:text-purple-800 hover:bg-purple-50 dark:text-purple-400 dark:hover:text-purple-300 dark:hover:bg-purple-900/20"
               aria-label="Map view">
                <svg class="w-5 h-5 ml-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div>
        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('super-admin.leads.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Name, email, phone..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status"
                                id="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ $status === 'has_website' ? 'Has Website' : ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source</label>
                        <select name="source"
                                id="source"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source }}" {{ request('source') === $source ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $source)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                        <a href="{{ route('super-admin.leads.index') }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leads as cards (same card style as show) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
            @forelse($leads as $lead)
                <a href="{{ route('super-admin.leads.edit', $lead) }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <div class="relative p-6 flex-1">
                            <div class="absolute top-0 right-0 m-2">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                    @if($lead->status === 'new') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($lead->status === 'contacted') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($lead->status === 'qualified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($lead->status === 'has_website') bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200
                                    @elseif($lead->status === 'won') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                    @elseif($lead->status === 'lost') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endif">
                                    {{ $lead->status === 'has_website' ? 'Has Website' : ucfirst($lead->status) }}
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate" title="{{ $lead->restaurant_name }}">
                                {{ $lead->restaurant_name }}
                            </h3>
                            @if($lead->street_address)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ trim(implode(', ', array_filter([$lead->street_address]))) }}
                                </p>
                            @endif
                            @if($lead->city || $lead->state)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ trim(implode(', ', array_filter([$lead->city, $lead->state, $lead->postal_code]))) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No leads found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($leads->hasPages())
            <div class="flex justify-center">
                {{ $leads->withQueryString()->links() }}
            </div>
        @endif

        <div class="text-center py-8">
            <a href="{{ route('super-admin.leads.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                + New Lead
            </a>
        </div>
    </div>
</x-super-admin-layout>
