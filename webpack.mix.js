require('dotenv').config();

const mix = require('laravel-mix');

if (mix.inProduction()) {
    mix.version();
}

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss')()])
    .sourceMaps();

mix.options({
    hmrOptions: {
        host: '0.0.0.0', // Docker binds to 0.0.0.0
        port: process.env.DOCKER_MIX_HOT_RELOAD_PORT,
    },
}).webpackConfig({
    output: {
        // Overrides the default 0.0.0.0 host (from above) to use localhost when
        // creating URLs, since the 0.0.0.0 address doesn't work when the
        // HMR server reloads in Chrome
        publicPath: `http://localhost:${process.env.DOCKER_MIX_HOT_RELOAD_PORT}/`,
    },
});
