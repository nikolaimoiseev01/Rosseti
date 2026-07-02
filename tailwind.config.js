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
                    700: '#1B2733'
                },
                black: {
                    400: "#6B7785",
                    500: "#595959"
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
