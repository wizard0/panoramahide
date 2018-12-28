const mix = require('laravel-mix');

const webpack = require('webpack');

const ExtractTextPlugin = require("extract-text-webpack-plugin");

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

mix
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js');

if (!mix.inProduction()) {
    mix.options({
        postCss: [
            require('autoprefixer')({
                browsers: [
                    'last 2 versions',
                    'iOS >= 8',
                    'Safari >= 8',
                ],
                cascade: false,
                flexbox: "no-2009"
            }),
            require('postcss-font-magician'),
            require('css-mqpacker'),
            require('postcss-remove-root'),
        ],
        processCssUrls: true,
        extractVueStyles: 'css/vue.css',
    });
    mix.sourceMaps();
    mix.browserSync(process.env.APP_URL);
    mix.disableNotifications();
}

if (mix.inProduction()) {
    mix.options({
        postCss: [
            require('autoprefixer')({
                browsers: [
                    'last 2 versions',
                    'iOS >= 8',
                    'Safari >= 8',
                ],
                cascade: false,
                flexbox: "no-2009"
            }),
            require('cssnano'),
            require('postcss-font-magician'),
            require('css-mqpacker'),
            require('postcss-remove-root'),
        ],
        processCssUrls: true,
        clearConsole: true,
    });
    mix.version();
}



