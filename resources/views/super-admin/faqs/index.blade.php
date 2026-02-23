<x-super-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('FAQs') }}</span>
        </div>
    </x-slot>

    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Drag items to reorder within each category. Order is saved automatically.</p>

        <div class="space-y-8">
            @foreach($grouped as $slug => $data)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $data['label'] }}</h2>
                    </div>
                    <ul class="faq-list divide-y divide-gray-200 dark:divide-gray-700" data-category="{{ $slug }}">
                        @forelse($data['faqs'] as $faq)
                            <li class="faq-item flex items-center gap-3 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-faq-id="{{ $faq->id }}">
                                <span class="cursor-grab active:cursor-grabbing text-gray-400 dark:text-gray-500 flex-shrink-0" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" /></svg>
                                </span>
                                <span class="flex-1 text-sm text-gray-900 dark:text-gray-100 min-w-0">{{ Str::limit($faq->question, 120) }}</span>
                                <span class="flex-shrink-0 flex items-center gap-2">
                                    <a href="{{ route('super-admin.faqs.edit', $faq) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium">Edit</a>
                                    <form action="{{ route('super-admin.faqs.destroy', $faq) }}" method="POST" class="inline" onsubmit="return confirm('Delete this FAQ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">Delete</button>
                                    </form>
                                </span>
                            </li>
                        @empty
                            <li class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No FAQs in this category. <a href="{{ route('super-admin.faqs.create') }}?category={{ $slug }}" class="text-purple-600 dark:text-purple-400 font-medium">Add one</a>.
                            </li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <div class="text-center py-8">
        <a href="{{ route('super-admin.faqs.create') }}"" 
        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            + New FAQ
        </a>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reorder endpoint and CSRF token
        const reorderUrl = @json(route('super-admin.faqs.reorder'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        document.querySelectorAll('.faq-list').forEach(function(listEl) {
            // Only make sortable if there are FAQ items (not just the empty-state li)
            const items = listEl.querySelectorAll('.faq-item[data-faq-id]');
            if (items.length === 0) return;

            new Sortable(listEl, {
                handle: '.cursor-grab',
                animation: 150,
                onEnd: function() {
                    const category = listEl.dataset.category;
                    const order = Array.from(listEl.querySelectorAll('.faq-item[data-faq-id]')).map(function(el) {
                        return parseInt(el.dataset.faqId, 10);
                    });
                    if (order.length === 0) return;

                    fetch(reorderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ category: category, order: order }),
                    }).then(function(r) {
                        if (!r.ok) throw new Error('Reorder failed');
                    }).catch(function() {
                        alert('Failed to save order. Please refresh and try again.');
                    });
                },
            });
        });
    });
    </script>
    @endpush
</x-super-admin-layout>
