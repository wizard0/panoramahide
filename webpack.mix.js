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

mix.js('resources/js/app.js', 'public/js');
if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: "inline-source-map"
    });
    mix.sass('resources/sass/app.scss', 'public/css').options({
        autoprefixer: {
            options: {
                browsers: [
                    'last 6 versions',
                ]
            }
        },
        postCss: [
            require('postcss-font-magician'),
            require('css-mqpacker'),
            require('postcss-remove-root'),
        ],
        processCssUrls: true,
        extractVueStyles: 'css/vue.css',
    }).sourceMaps();
    mix.browserSync(process.env.APP_URL);
    mix.disableNotifications();
}

if (mix.inProduction()) {
    mix.sass('resources/sass/app.scss', 'public/css').options({
        autoprefixer: {
            options: {
                browsers: [
                    'last 6 versions',
                ]
            }
        },
        postCss: [
            require('cssnano'),
            require('postcss-font-magician'),
            require('css-mqpacker'),
            require('postcss-remove-root'),
        ],
        processCssUrls: true,
        clearConsole: true,
    }).version();
}



