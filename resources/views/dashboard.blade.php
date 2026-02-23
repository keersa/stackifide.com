<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-lg">
                        {{ __('Welcome,') }} {{ Auth::user()->full_name ?: Auth::user()->email }}!
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        {{ __('You are logged in.') }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                            {{ __('Edit your profile') }} →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
