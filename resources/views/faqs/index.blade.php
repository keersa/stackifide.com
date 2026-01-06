<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8 !max-w-[900px] mx-auto">
                    <div class="space-y-4" x-data="{ activeId: null }">
                        @foreach($faqs as $index => $faq)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden transition-shadow duration-200 hover:shadow-md">
                                <button
                                    @click="activeId = activeId === {{ $index }} ? null : {{ $index }}"
                                    class="w-full px-6 py-4 text-left flex items-center justify-between bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-inset"
                                >
                                    <span class="font-semibold text-gray-900 dark:text-gray-100 pr-4">
                                        {{ $faq['question'] }}
                                    </span>
                                    <svg
                                        class="w-5 h-5 text-gray-500 dark:text-gray-400 flex-shrink-0 transition-transform duration-300"
                                        :class="{ 'rotate-180': activeId === {{ $index }} }"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div
                                    x-show="activeId === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    class="px-6 py-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700"
                                >
                                    <p class="leading-relaxed">
                                        {{ $faq['answer'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    