<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-gray-400 dark:bg-gray-800 bg-opacity-10 dark:bg-opacity-30 text-black dark:text-white rounded-2xl p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-widest font-semibold text-black dark:text-white">Talk to us directly</p>
                    <h3 class="mt-2 text-2xl font-black">Call Us Now</h3>
                    <a href="tel:8139401074" class="mt-4 inline-block text-3xl font-black tracking-tight hover:opacity-90">
                        813-940-1074
                    </a>
                    <p class="mt-4 text-sm text-black dark:text-white">
                        Prefer speaking with someone live? We are happy to answer questions about plans, timelines, and next steps. Or, if you prefert to chat, just click the icon in the bottom right of this page.
                    </p>
                </div>

                <div class="lg:col-span-2 bg-gray-400 dark:bg-gray-800 bg-opacity-10 dark:bg-opacity-30 text-black dark:text-white rounded-2xl shadow-lg">
                    <div class="p-6 text-gray-900 dark:text-white">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Send Us a Message</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Tell us about your restaurant and what you need. We will follow up shortly.</p>

                        @if (session('success'))
                            <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="post" class="space-y-4">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="text-black dark:text-white bg-white dark:bg-gray-800 dark:bg-opacity-30 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-900 shadow-sm text-sm">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="text-black dark:text-white bg-white dark:bg-gray-800 dark:bg-opacity-30 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-900 shadow-sm text-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-white">Message</label>
                                <textarea name="message" id="message" rows="5" class="text-black dark:text-white bg-white dark:bg-gray-800 dark:bg-opacity-30 mt-1 block w-full rounded-md border-gray-300 dark:border-gray-900 shadow-sm text-sm">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    