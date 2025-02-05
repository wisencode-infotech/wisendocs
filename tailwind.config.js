/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class', // Enable class-based dark mode
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.jsx",
        "./resources/**/*.js",
        "./resources/**/*.css",
        './node_modules/primereact/**/*.{js,ts,jsx,tsx}',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
            },
            colors: {
                theme: {
                    DEFAULT: '#3d5f8a', // Default primary color (light mode)
                    dark: '#0E0D0E', // Dark mode primary color
                    light: '#FFFFFF', // Light theme accent color
                    accent: '#F1F8FF', // Light theme accent background
                    code: '#4de77a', // Code highlighting color
                    codebg: '#3f3f3f', // Code background (dark gray)
                    lightBackground: '#f0f2f5', // Light mode background color (white)
                    lightText: '#333333', // Light mode text color (dark gray)
                    lightBorder: '#D9D9D9', // Light mode border color (neutral gray)
                    darkBackground: '#181818', // Dark mode background color (blackish)
                    darkText: '#E0E0E0', // Dark mode text color (light gray)
                    darkBorder: '#333333', // Dark mode border color (darker gray)
                },
            },
        },
    },
    plugins: [],
};