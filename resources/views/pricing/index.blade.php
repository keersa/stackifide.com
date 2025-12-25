<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 lg:p-24">
            <div class="grid grid-cols-3 gap-4 mx-auto max-w-7xl text-center">
                <div class="bg-gray-100 dark:bg-gray-800 py-16 px-4 rounded-lg">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Free</h2>
                </div>
                <div class="bg-gray-100 dark:bg-gray-800 py-16 px -4 rounded-lg">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Basic</h2>
                </div>
                <div class="bg-gray-100 dark:bg-gray-800 py-16 px-4 rounded-lg">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pro</h2>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    