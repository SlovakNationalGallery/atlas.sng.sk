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
