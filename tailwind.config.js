import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const baseClasses = [
    // Text colors
    'text-blue-300', 'text-blue-400', 'text-blue-500', 'text-blue-600', 'text-blue-700', 'text-blue-900',
    'text-green-300',
    'text-black-100', 'text-black-200', 'text-black-300', 'text-black-400', 'text-black-500', 'text-black-600', 'text-black-900',
    'text-grey',
    'text-white',
    // Background colors
    'bg-blue-300', 'bg-blue-400', 'bg-blue-500', 'bg-blue-600', 'bg-blue-700', 'bg-blue-900',
    'bg-green-300',
    'bg-black-100', 'bg-black-200', 'bg-black-300', 'bg-black-400', 'bg-black-500', 'bg-black-600', 'bg-black-900',
    'bg-grey',
    'bg-white',
    // Font weights
    'font-light', 'font-normal', 'font-medium', 'font-semibold', 'font-bold', 'font-extrabold',
];

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
        ...baseClasses,
        ...baseClasses.map(cls => '!' + cls),
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['PFDinTextCondPro', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blue:  {
                    300: '#0C4EBB',
                    400: '#2196F3',
                    500: '#005A99',
                    600: '#00355A',
                    700: '#1B2733',
                    900: '#0E3A5C'
                },
                green: {
                  300: '#009688'
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
                grey: '#999999',
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
