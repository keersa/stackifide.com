<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Websites Management') }}</span>
        </div>
    </x-slot>

    <div>
        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('super-admin.websites.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" 
                               name="search" 
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Name, domain..."
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
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Plan</label>
                        <select name="plan" 
                                id="plan"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">All Plans</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan }}" {{ request('plan') === $plan ? 'selected' : '' }}>
                                    {{ ucfirst($plan) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="deleted" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deleted</label>
                        <select name="deleted" 
                                id="deleted"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Active Only</option>
                            <option value="with" {{ request('deleted') === 'with' ? 'selected' : '' }}>With Deleted</option>
                            <option value="only" {{ request('deleted') === 'only' ? 'selected' : '' }}>Deleted Only</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" 
                                class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                        <a href="{{ route('super-admin.websites.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Websites Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Domain</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Owner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($websites as $website)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 {{ $website->trashed() ? 'opacity-60' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $website->name }}
                                        @if($website->trashed())
                                            <span class="ml-2 text-xs text-red-600 dark:text-red-400">(Deleted)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($website->domain)
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $website->domain }}
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-400">
                                            -
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($website->isActive()) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($website->isOnTrial()) bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                        @endif">
                                        {{ $website->isActive() ? 'Active' : ($website->isOnTrial() ? 'Trial' : 'Inactive') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ ucfirst($website->plan) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($website->user)
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $website->user->full_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $website->user->email }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">No owner</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $website->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($website->trashed())
                                        <form method="POST" action="{{ route('super-admin.websites.restore', $website->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3"
                                                    onclick="return confirm('Are you sure you want to restore this website?')">
                                                Restore
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('super-admin.websites.force-delete', $website->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to permanently delete this website? This action cannot be undone.')">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('super-admin.websites.show', $website) }}" 
                                           class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 mr-3">
                                            View
                                        </a>
                                        <a href="{{ route('super-admin.websites.edit', $website) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-3">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('super-admin.websites.destroy', $website) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                    onclick="return confirm('Are you sure you want to delete this website?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No Websites found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4">
                {{ $websites->links() }}
            </div>
        </div>

        <div class="text-center py-8">
            <a href="{{ route('super-admin.websites.create') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                + New Website
            </a>
        </div>
    </div>
</x-super-admin-layout>
