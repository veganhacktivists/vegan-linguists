const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  mode: 'jit',
  purge: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './app/View/**/*.php',
    './resources/js/**/*.js',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        // Design palette: https://grayscale.design/app?lums=92.72,85.96,76.12,48.53,32.68,20.15,15.15,11.44,6.93,1.73&palettes=%2345A3DD,%23191515,%23B6674B,%23E8E1DB,%23A1C64F&filters=0%7C0,-8.8%7C0,0%7C0,0%7C0,0%7C0&names=brandBlue,brandBrown,brandClay,brandBeige,brandGreen&labels=,,,,
        brandBlue: {
          50: 'rgb(241, 248, 252)',
          100: 'rgb(227, 241, 250)',
          200: 'rgb(205, 230, 246)',
          300: 'rgb(130, 193, 232)',
          400: 'rgb(69, 163, 221)',
          500: 'rgb(35, 130, 189)',
          600: 'rgb(30, 114, 166)',
          700: 'rgb(27, 100, 146)',
          800: 'rgb(21, 79, 115)',
          900: 'rgb(10, 38, 55)',
        },
        brandBrown: {
          50: 'rgb(246, 247, 245)',
          100: 'rgb(238, 239, 236)',
          200: 'rgb(227, 227, 221)',
          300: 'rgb(187, 185, 173)',
          400: 'rgb(160, 155, 141)',
          500: 'rgb(132, 123, 110)',
          600: 'rgb(118, 107, 98)',
          700: 'rgb(106, 93, 88)',
          800: 'rgb(84, 72, 70)',
          900: 'rgb(41, 34, 34)',
        },
        brandClay: {
          50: 'rgb(251, 246, 244)',
          100: 'rgb(246, 237, 233)',
          200: 'rgb(240, 223, 217)',
          300: 'rgb(217, 176, 161)',
          400: 'rgb(200, 141, 120)',
          500: 'rgb(182, 103, 75)',
          600: 'rgb(160, 90, 65)',
          700: 'rgb(140, 79, 57)',
          800: 'rgb(110, 62, 45)',
          900: 'rgb(53, 30, 22)',
        },
        brandBeige: {
          50: 'rgb(248, 246, 244)',
          100: 'rgb(242, 238, 235)',
          200: 'rgb(232, 225, 219)',
          300: 'rgb(199, 182, 167)',
          400: 'rgb(175, 151, 130)',
          500: 'rgb(147, 119, 94)',
          600: 'rgb(129, 104, 82)',
          700: 'rgb(113, 91, 72)',
          800: 'rgb(88, 71, 56)',
          900: 'rgb(42, 34, 27)',
        },
        brandGreen: {
          50: 'rgb(245, 249, 236)',
          100: 'rgb(234, 242, 215)',
          200: 'rgb(217, 232, 184)',
          300: 'rgb(160, 198, 79)',
          400: 'rgb(131, 167, 54)',
          500: 'rgb(105, 134, 43)',
          600: 'rgb(92, 117, 38)',
          700: 'rgb(80, 102, 33)',
          800: 'rgb(63, 80, 26)',
          900: 'rgb(31, 39, 13)',
        },
      },
    },
  },

  variants: {
    extend: {
      opacity: ['disabled'],
      backgroundColor: ['group-focus'],
    },
  },

  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
