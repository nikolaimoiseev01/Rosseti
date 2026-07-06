import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'fill-white',
        'fill-blue-500',
        'fill-blue',
        // Report block colors
        'text-white', 'bg-white', 'border-white',
        'text-blue-400', 'bg-blue-400', 'border-blue-400',
        'text-blue-500', 'bg-blue-500', 'border-blue-500',
        'text-blue-600', 'bg-blue-600', 'border-blue-600',
        'text-blue-700', 'bg-blue-700', 'border-blue-700',
        'text-black-400', 'text-black-500',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['PFDinTextCondPro', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue:  {
                    400: '#2196F3',
                    500: '#005B9C',
                    600: '#00355A',
                    700: '#1B2733',
                    900: '#0E3A5C'
                },
                black: {
                    100: '#E1E7F0',
                    200: '#c3c3c3',
                    300: '#CDD6DE',
                    400: "#6B7785",
                    500: "#595959",
                    600: '#F1F5FC',
                    900: '#000000'
                },
                white: '#FFFFFF'
            },
            screens: {
                '2xl': {'max': '1535px'}, // => @media (max-width: 1535px) { ... }
                'xl': {'max': '1279px'}, // => @media (max-width: 1279px) { ... }
                'lg': {'max': '1023px'}, // => @media (max-width: 1023px) { ... }
                'md': {'max': '767px'}, // => @media (max-width: 767px) { ... }
                'sm': {'max': '639px'}, // => @media (max-width: 639px) { ... }
            },
        },
    },
    plugins: [forms],
};
