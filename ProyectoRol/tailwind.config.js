const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': "#3DA0A9",
            },
            backgroundColor: {
                'primary1': "#1B1B1B",
                'secundary1': '#1C1D1E',
                'primary2': '#0F0F0F',
            },
            backgroundImage: theme => ({
                'ficha' : "url('/imagenes/general/plantilla.png')",
            })
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],

};
