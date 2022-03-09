module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      padding: {
        full: '100%',
      },
    },
    colors: {
      black: '#000',
      white: '#fff',
      red: '#f44336',
      green: '#0DF043',
      gray: {
        100: '#eeeff1',
        400: '#b9bbc6'
      }
    },
    fontFamily: {
      sans: ['GTWalsheim', 'sans-serif']
    },
    fontSize: {
      sm: ['14px'],
      base: ['18px'],
      lg: ['20px'],
      xl: ['22px'],
      '2xl': ['28px']
    },
    fontWeight: {
      normal: '400',
      bold: '700'
    }
  },
  plugins: [],
}
