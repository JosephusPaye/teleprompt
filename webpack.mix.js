require('dotenv').config();

const mix = require('laravel-mix');

if (mix.inProduction()) {
  mix.version();
}

mix.js('resources/app/main.js', 'public/js/app.js').sourceMaps();

mix
  .options({
    postCss: [require('tailwindcss')()],
    hmrOptions: {
      processCssUrls: false,
      host: '0.0.0.0', // Docker binds to 0.0.0.0
      port: process.env.DOCKER_MIX_HOT_RELOAD_PORT,
    },
  })
  .webpackConfig({
    output: {
      // Overrides the default 0.0.0.0 host (from above) to use localhost when
      // creating URLs, since the 0.0.0.0 address doesn't work when the
      // HMR server reloads in Chrome
      publicPath: `http://localhost:${process.env.DOCKER_MIX_HOT_RELOAD_PORT}/`,
    },
  });
