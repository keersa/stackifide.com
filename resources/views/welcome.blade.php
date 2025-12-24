<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center mt-20">
                <x-application-logo class="block h-40 w-auto fill-current text-gray-800 dark:text-gray-200 mx-auto animate-[fadeInScale_1s_ease-out] hover:scale-105 transition-transform duration-300" />
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mt-4 animate-[fadeIn_1.2s_ease-out]">Stackifide Solutions</h1>
            </div>

            <style>
                @keyframes fadeInScale {
                    from {
                        opacity: 0;
                        transform: scale(0.9);
                    }
                    to {
                        opacity: 1;
                        transform: scale(1);
                    }
                }
                
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            </style>

     
        </div>
    </div>
</x-app-layout>
