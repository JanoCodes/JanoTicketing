const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['lodash', 'jquery', 'foundation-sites', 'vue', 'axios'])
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.copy('node_modules/font-awesome/fonts', 'public/fonts');

if (mix.config.inProduction) {
    mix.version();
}