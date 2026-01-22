<button {{ $attributes->merge(['type' => 'submit', 'class' => 'block bg-lime-500 dark:bg-lime-600 text-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-black dark:text-white uppercase tracking-widest hover:bg-lime-400 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
