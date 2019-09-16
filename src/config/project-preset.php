<?php

return [

    'libraries' => [

        'sebastiaanluca/laravel-module-loader',
        'sebastiaanluca/laravel-resource-flow' => 'dev-develop',
        'sebastiaanluca/laravel-router',

    ],

    'dev_libraries' => [

        'barryvdh/laravel-ide-helper',
        'fzaninotto/faker',
        'kint-php/kint',
        'mockery/mockery',
        'nunomaduro/collision',
        'phpunit/phpunit',
        'roave/security-advisories' => 'dev-master',
        'sebastiaanluca/php-codesniffer-ruleset',

    ],

    'packages' => [

        'axios',
        'tailwindcss',
        'vue',
        'vue-feather-icons',
        'vue-template-compiler',

    ],

    'dev_packages' => [

        'browser-sync',
        'browser-sync-webpack-plugin',
        'cross-env',
        'laravel-mix',
        'laravel-mix-purgecss',
        'postcss-import',
        'postcss-preset-env',

    ],

    'composer_scripts' => [

        'post-update-cmd' => '@autocomplete',
        'autocomplete' => [
            '@php artisan ide-helper:generate',
            '@php artisan ide-helper:meta',
        ],
        'optimize' => [
            '@php artisan modules:refresh',
            '@autocomplete',
        ],
        'clear' => [
            '@php artisan cache:clear',
            '@php artisan config:clear',
            '@php artisan route:clear',
            '@php artisan view:clear',
            '@php artisan modules:clear',
        ],
        'composer-validate' => '@composer validate --no-check-all --strict',
        'codesniffer-check' => 'vendor/bin/phpcs --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1',
        'codesniffer-fix' => 'vendor/bin/phpcbf --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 || exit 0',
        'analyze' => [
            '@composer-validate',
            '@codesniffer-check',
        ],
        'test' => 'vendor/bin/phpunit',
        'check' => [
            '@analyze',
            '@test',
        ],
    ],

    'config' => [

        'ide-helper',

    ],

    'post_preset_commands' => [

        'php artisan modules:refresh',

    ],

];
