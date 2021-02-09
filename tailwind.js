module.exports = {
    purge: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
  theme: {
    fontFamily: {
    //   display: ['Expletus Sans', 'Blinker', 'Segoe UI', 'Helvetica Neue', 'Arial', 'sans-serif'],
      body: ['Lato', 'Segoe UI', 'Helvetica Neue', 'Arial', 'sans-serif'],
    },
    inset: {
      '0': '0',
      '2': '2rem',
      '3': '3rem',
      '4': '4rem',
      '5': '5rem',
      '8': '8rem',
      '10': '10rem',
      '12': '12rem',
    },

    extend: {
      colors: {
        dark: {
          100: 'rgba(0,0,0,0.1)',
          200: 'rgba(0,0,0,0.2)',
          300: 'rgba(0,0,0,0.3)',
          400: 'rgba(0,0,0,0.4)',
          500: 'rgba(0,0,0,0.5)',
          600: 'rgba(0,0,0,0.6)',
          700: 'rgba(0,0,0,0.7)',
          800: 'rgba(0,0,0,0.8)',
          900: 'rgba(0,0,0,0.9)'
        },
        light: {
          100: 'rgba(255,255,255,0.1)',
          200: 'rgba(255,255,255,0.2)',
          300: 'rgba(255,255,255,0.3)',
          400: 'rgba(255,255,255,0.4)',
          500: 'rgba(255,255,255,0.5)',
          600: 'rgba(255,255,255,0.6)',
          700: 'rgba(255,255,255,0.7)',
          800: 'rgba(255,255,255,0.8)',
          900: 'rgba(255,255,255,0.9)'
        }
      },
      spacing: {
          '32rem': '32rem',
          '36rem': '36rem',
          '40rem': '40rem',
      }
    }
  },
  variants: {},
  plugins: []
}
