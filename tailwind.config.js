module.exports = {
  content: [
    'templates/**/*.html.twig',
    'assets/js/**/*.js',
    'assets/js/**/*.jsx',
  ],
  theme: {
    extend: {
      colors: {
        'button-green': '#84947b',

      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
