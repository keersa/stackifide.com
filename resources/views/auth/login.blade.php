<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="py-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-200">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-4">
            <x-primary-button class="block w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <div class="grid grid-cols-2 gap-2 items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="text-sm text-center uppercase bg-gray-200 dark:bg-gray-300 px-4 py-2 font-semibold text-xs text-gray-600 dark:text-gray-500 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
            <a class="text-sm text-center uppercase bg-gray-200 dark:bg-gray-300 px-4 py-2 font-semibold text-xs text-gray-600 dark:text-gray-500 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                {{ __('Register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
