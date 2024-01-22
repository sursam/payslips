const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.webpackConfig({
    devtool: 'inline-source-map',
});
mix.copyDirectory('resources/assets', 'public/assets');
/* mix.copyDirectory('resources/assets/images', 'public/assets/images');
mix.copyDirectory('resources/assets/downloads', 'public/assets/downloads');
mix.copyDirectory('resources/assets/js', 'public/assets/js');
mix.copyDirectory('resources/assets/vendor', 'public/assets/vendor');
mix.copyDirectory('resources/assets/frontend/css', 'public/assets/frontend/css');
mix.copyDirectory('resources/assets/frontend/images', 'public/assets/frontend/images');
mix.copyDirectory('resources/assets/frontend/js', 'public/assets/frontend/js');
mix.copyDirectory('resources/assets/frontend/custom/js', 'public/assets/frontend/js');
mix.sass('resources/assets/scss/sb-admin-2.scss', 'public/assets/css/style.css').options({
    processCssUrls: false
}).minify('public/assets/css/style.css');
mix.combine(['resources/assets/frontend/custom/css/style.css','resources/assets/frontend/custom/css/responsive.css'],'public/assets/frontend/css/style.css');
mix.sourceMaps(); */
