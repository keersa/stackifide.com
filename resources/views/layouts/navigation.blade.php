<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="flex flex-col lg:flex-row w-full max-w-7xl p-4 mx-auto">
        <!-- Logo and Hamburger -->
        <div class="flex items-center justify-between lg:justify-start">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-logo class="block max-w-[60px] pl-4 fill-current text-gray-800" />
                    <span class="text-gray-800 font-semibold text-3xl mt-1">Stackifide</span>
                </a>
            </div>

            <!-- Hamburger Button (Mobile Only) -->
            <button @click="open = ! open" 
                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors"
                    aria-label="Toggle menu">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex lg:items-center lg:space-x-4 lg:ml-auto">
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            Dashboard
                        </a>
                        <a href="{{ url('/websites') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            Websites
                        </a>
                        <a href="{{ url('/profile') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            Account
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('about.index') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            About
                        </a>
                        <a href="{{ route('contact.index') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            Contact
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-md leading-normal transition-colors">
                            Log In
                        </a>
                    @endauth
                </nav>
            @endif
        </div>
    </div>

    <!-- Mobile Navigation Menu (Slides Out) -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="-translate-x-full opacity-0"
         x-transition:enter-end="translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-x-0 opacity-100"
         x-transition:leave-end="-translate-x-full opacity-0"
         class="lg:hidden fixed top-0 left-0 h-full w-64 bg-white shadow-xl z-50 overflow-y-auto"
         style="display: none;">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <span class="text-gray-800 font-semibold text-xl">Menu</span>
            <button @click="open = false" 
                    class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Content -->
        <div class="p-4 space-y-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        Dashboard
                    </a>
                    <a href="{{ url('/websites') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        Websites
                    </a>
                    <a href="{{ url('/profile') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        Account
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                @click="open = false"
                                class="block w-full text-left px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        About
                    </a>
                    <a href="{{ route('login') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        Contact
                    </a>
                    <a href="{{ route('login') }}"
                       @click="open = false"
                       class="block px-4 py-3 text-[#1b1b18] border border-transparent hover:bg-gray-50 rounded-md text-base font-medium transition-colors">
                        Log In
                    </a>
                @endauth
            @endif
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="open"
         @click="open = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="lg:hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-40"
         style="display: none;">
    </div>
</nav>
