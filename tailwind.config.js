const typography = require('@tailwindcss/typography');

module.exports = {
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true,
  },
  plugins: [typography],
  purge: [
    './resources/**/*.vue',
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
};
