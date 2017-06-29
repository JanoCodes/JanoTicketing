const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['lodash', 'jquery', 'foundation-sites', 'vue', 'axios'])
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.copy('logo.png', 'public/images/logo.png');

if (mix.inProduction()) {
    mix.version();
}