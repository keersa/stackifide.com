<x-super-admin-layout>
    <x-slot name="header">{{ __('Edit FAQ') }}</x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-3xl">
        <div class="p-6">
            <form method="POST" action="{{ route('super-admin.faqs.update', $faq) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category *</label>
                        <select name="category" id="category" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat['slug'] }}" {{ old('category', $faq->category) === $cat['slug'] ? 'selected' : '' }}>
                                    {{ $cat['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question *</label>
                        <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required maxlength="1000"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('question')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Answer *</label>
                        <textarea name="answer" id="answer" rows="5" required maxlength="5000"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Update FAQ
                    </button>
                    <a href="{{ route('super-admin.faqs.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-super-admin-layout>
