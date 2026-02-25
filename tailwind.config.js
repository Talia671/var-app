import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    darkMode: 'class', // Enable class-based dark mode

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Day Mode Colors
                ivory: '#FFFFF0', // Main background for Day
                cream: '#FFFDD0', // Alternative
                primary: {
                    DEFAULT: '#F47920', // Pupuk Kaltim Orange
                    dark: '#d6600c',
                },
                secondary: {
                    DEFAULT: '#1268B3', // Pupuk Kaltim Blue
                    dark: '#0e5290',
                },
                // Night Mode Colors (Custom Professional Recommendation)
                night: {
                    bg: '#0F172A', // Slate 900
                    card: '#1E293B', // Slate 800
                    text: '#E2E8F0', // Slate 200
                    border: '#334155', // Slate 700
                }
            },
        },
    },

    plugins: [forms],
};
