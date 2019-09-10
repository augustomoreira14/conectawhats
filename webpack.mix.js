const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.scripts([
    'resources/js/template/core/jquery.3.2.1.min.js',
    'resources/js/template/core/popper.min.js',
    'resources/js/template/core/bootstrap.min.js',
    'resources/js/template/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js',
    'resources/js/template/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js',
    'resources/js/template/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
    'resources/js/template/plugin/moment/moment.min.js',
    'resources/js/template/plugin/chart.js/chart.min.js',
    'resources/js/template/plugin/jquery.sparkline/jquery.sparkline.min.js',
    'resources/js/template/plugin/chart-circle/circles.min.js',
    'resources/js/template/plugin/bootstrap-notify/bootstrap-notify.min.js',
    'resources/js/template/plugin/jquery.validate/jquery.validate.min.js',
    'resources/js/template/millenium.min.js'
], 'public/js/main.js');

mix.styles([
    'resources/css/font-awesome.css',
    'resources/css/bootstrap.min.css',
    'resources/css/millenium.css',
    'resources/css/demo.css',
], 'public/css/style.css');