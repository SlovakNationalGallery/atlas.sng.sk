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
    fontWeight: {
      normal: '400',
      bold: '700'
    }
  },
  plugins: [],
}
