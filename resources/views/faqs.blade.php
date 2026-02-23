<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12" x-data="{ openIds: [] }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Floating category menu (left) -->
                <aside class="lg:w-56 flex-shrink-0 order-2 lg:order-1">
                    <div class="lg:sticky lg:top-24">
                        <nav class="flex lg:flex-col gap-2 overflow-x-auto pb-2 lg:pb-0 lg:overflow-visible" aria-label="FAQ categories">
                            @foreach($categories as $cat)
                                <a href="#faq-{{ $cat['slug'] }}"
                                   class="faq-category-link flex-shrink-0 lg:flex-shrink px-4 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:bg-black dark:bg-opacity-40 dark:text-white hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-opacity-10 transition-colors duration-200 border border-gray-200 dark:border-black"
                                   data-category="{{ $cat['slug'] }}"
                                >
                                    {{ $cat['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </aside>

                <!-- FAQ sections (main content) -->
                <main class="flex-1 min-w-0 order-1 lg:order-2 scroll-mt-24">
                    @foreach($categories as $cat)
                        @php
                            $sectionFaqs = $faqs->where('category', $cat['slug']);
                        @endphp
                        @if(count($sectionFaqs) > 0)
                            <section id="faq-{{ $cat['slug'] }}" class="scroll-mt-28 mb-12 first:mt-0">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                                    {{ $cat['label'] }}
                                </h3>
                                <div class="space-y-3">
                                    @foreach($sectionFaqs as $index => $faq)
                                        @php $accordionId = $cat['slug'] . '-' . $index; @endphp
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden transition-shadow duration-200 hover:shadow-md bg-white dark:bg-gray-800/50">
                                            <button
                                                @click="openIds.includes('{{ $accordionId }}') ? openIds = openIds.filter(i => i !== '{{ $accordionId }}') : openIds = [...openIds, '{{ $accordionId }}']"
                                                class="w-full px-5 py-4 text-left flex items-center justify-between bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors duration-200 focus:outline-none rounded-xl"
                                            >
                                                <span class="font-semibold text-gray-900 dark:text-gray-100 pr-4 text-left">
                                                    {{ $faq->question }}
                                                </span>
                                                <svg
                                                    class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0 transition-transform duration-300"
                                                    :class="{ 'rotate-180': openIds.includes('{{ $accordionId }}') }"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div
                                                x-show="openIds.includes('{{ $accordionId }}')"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2"
                                                class="border-t border-gray-200 dark:border-gray-700 overflow-hidden"
                                                style="display: none;"
                                            >
                                                <div class="px-5 py-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                                    <p class="leading-relaxed">
                                                        {{ $faq->answer }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                </main>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.faq-category-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('href').slice(1);
                var target = document.getElementById(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</x-app-layout>
