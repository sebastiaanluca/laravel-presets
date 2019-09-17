const mix = require('laravel-mix')
const path = require('path')

require('laravel-mix-purgecss')
require('dotenv').config()

/*
 * Configure
 */

const postCssConfig = [
    require('postcss-import')(),
    require('postcss-nested')(),
    require('postcss-preset-env')(),
    require('tailwindcss'),
]

mix.options({
    // Since we don't do any image preprocessing and write url's that are
    // relative to the site root, we don't want the CSS loader to try to
    // follow paths in `url()` functions.
    processCssUrls: false,
})

mix.webpackConfig({
    resolve: {
        alias: {
            js: path.resolve(__dirname, 'resources/js'),
        },
    },
    stats: {
        errors: true,
    },
})

if (! mix.inProduction()) {
    mix.sourceMaps()
}

if (mix.inProduction()) {
    mix.purgeCss({
        enabled: true,
        folders: [
            'app/Modules',
            'resources',
        ],
        whitelistPatterns: [],
    })

    mix.version()
}

mix.browserSync({
    proxy: process.env.BROWSERSYNC_PROXY,
    open: false,
    https: true,
    files: [
        './app/Modules/**/*.blade.php',
        './resources/views/**/*.blade.php',
    ],
    reloadDelay: process.env.BROWSERSYNC_DELAY ? parseInt(process.env.BROWSERSYNC_DELAY) : 0,
    snippetOptions: {
        rule: {
            // Laravel Ignition workaround
            match: /<\/body>/i,
            fn: function (snippet, match) {
                return snippet + match
            }
        }
    }
})

mix.disableNotifications()

/*
 * Build
 */

// Extract vendor libraries
mix.extract()

// Include a PostCSS configuration array per build so it doesn't warn us about PostCSS doing nothing
// Reference: https://github.com/JeffreyWay/laravel-mix/issues/1979
mix.postCss('resources/css/app.css', 'public/css/app.css', postCssConfig)

// Fake build file to fix laravel-mix upgrade issue
// Reference: https://github.com/JeffreyWay/laravel-mix/issues/2030
mix.js('resources/js/fake.js', 'public/js/fake.js')
mix.js('resources/js/app.js', 'public/js/app.js')
