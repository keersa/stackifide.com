<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center my-36">
                <x-application-logo class="block h-[200px] w-auto fill-current text-gray-800 dark:text-gray-200 mx-auto animate-[fadeInScale_1s_ease-out] hover:scale-105 transition-transform duration-300" />
                <h1 class="text-4xl font-bold text-gray-800 dark:text-black mt-4 animate-[fadeIn_1.2s_ease-out]">Stackifide Solutions</h1>
            </div>

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

    <script>
    // Array of hex color codes
    // const colors = ['#a3e635', '#33FFBD', '#8E44AD', '#F1C40F', '#1ABC9C'];

    // let index = 0;
    // const interval = 5000; // Time in ms between color changes

    // function changeBackgroundColor() {
    //     document.body.style.backgroundColor = colors[index];
    //     index = (index + 1) % colors.length;
    // }

    // // Initial color set
    // changeBackgroundColor();

    // // Start cycling colors
    // setInterval(changeBackgroundColor, interval);
    </script>
</x-app-layout>
