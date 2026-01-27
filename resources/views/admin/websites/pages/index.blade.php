<x-admin-layout>
    <x-admin-website-header :website="$website" title="Manage Pages" />

    <div class="py-2">
        <div class="px-2 pb-4 flex items-center justify-between">
            <h3 class="font-black text-gray-900 dark:text-white text-2xl tracking-tighter">{{ __('Manage Pages') }}</h3>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-8"></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pages-table" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($pages as $page)
                            <tr data-id="{{ $page->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-move">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                    </svg>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $page->title }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $page->slug }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->is_published ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                        {{ $page->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.websites.pages.edit', [$website, $page]) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-3">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.websites.pages.destroy', [$website, $page]) }}" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No pages yet.
                                    <a href="{{ route('admin.websites.pages.create', $website) }}" 
                                       class="ml-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                        Create your first page
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-right py-4">
        <a href="{{ route('admin.websites.pages.create', $website) }}" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
            + New Page
        </a>
    </div>

    <!-- SortableJS Library -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('pages-table');
            
            if (tbody) {
                const sortable = Sortable.create(tbody, {
                    handle: 'td:first-child, svg',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onEnd: function(evt) {
                        const items = Array.from(tbody.querySelectorAll('tr[data-id]')).map((row, index) => ({
                            id: row.getAttribute('data-id'),
                            sort_order: index + 1
                        }));

                        fetch('{{ route("admin.websites.pages.reorder", $website) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ items: items })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Optional: Show a success message
                                console.log('Pages reordered successfully');
                            }
                        })
                        .catch(error => {
                            console.error('Error reordering pages:', error);
                        });
                    }
                });
            }
        });
    </script>
</x-admin-layout>
