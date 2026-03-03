import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    blue: '#1a7dbc',
                    green: '#F1C40F',
                },
            },
            fontFamily: {
                sans: ['ABeeZee', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', 'Georgia', 'serif'],
                // Homepage: Google Fonts (loaded in layouts/home.blade.php)
                'home-display': ['Outfit', 'Figtree', ...defaultTheme.fontFamily.sans],
                'home-sans': ['ABeeZee', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
