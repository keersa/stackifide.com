<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif
    </head>

    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full text-sm mb-6 not-has-[nav]:hidden bg-gray-100">

            <div class="flex flex-col lg:flex-row w-full max-w-7xl p-4 mx-auto">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <x-application-logo class="block max-w-[60px] pl-4 fill-current text-gray-800" />
                        <span class="text-gray-800 font-semibold text-3xl mt-1">Stackifide</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:justify-end lg:ml-auto">
                    @if (Route::has('login'))
                        <nav class="max-w-[1200px] mx-auto flex items-center justify-end gap-4">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>


        </header>
        <div class="text-center mt-20">
            <x-application-logo class="block h-40 w-auto fill-current text-gray-800 mx-auto" />
            <h1 class="text-4xl font-bold text-gray-800 mt-4">Stackifide</h1>
        </div>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            
                    
                
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">

                    
        


            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
