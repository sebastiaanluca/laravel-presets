<?php

use SebastiaanLuca\Preset\Actions\AddComposerPackages;
use SebastiaanLuca\Preset\Actions\AddNpmPackages;
use SebastiaanLuca\Preset\Actions\CleanUpObsoletes;
use SebastiaanLuca\Preset\Actions\ConfigureComposer;
use SebastiaanLuca\Preset\Actions\MoveFramework;
use SebastiaanLuca\Preset\Actions\RemovePresetPackage;
use SebastiaanLuca\Preset\Actions\ScaffoldApplication;
use SebastiaanLuca\Preset\Actions\ScaffoldConfiguration;
use SebastiaanLuca\Preset\Actions\ScaffoldResources;

return [

    'actions' => [

        'Remove obsolete directories and files' => CleanUpObsoletes::class,
        'Move framework to a sub directory' => MoveFramework::class,
        'Scaffold application directories' => ScaffoldApplication::class,
        'Scaffold configuration' => ScaffoldConfiguration::class,
        'Scaffold resources' => ScaffoldResources::class,
        'Configure Composer' => ConfigureComposer::class,
        'Add Composer packages' => AddComposerPackages::class,
        'Add NPM packages' => AddNpmPackages::class,
        'Remove preset package' => RemovePresetPackage::class,

    ],

    'files' => [

        '.browserslistrc',
        '.editorconfig',
        '.env',
        '.env.example',
        '.env.testing',
        '.gitattributes',
        '.gitignore',
        '.shiftrc',
        'phpcs.xml.dist',
        'phpunit.dusk.xml',
        'phpunit.xml.dist',
        'README.md',
        'SCRATch.md',
        'tailwind.config.js',
        'webpack.mix.js',

        'app/Framework/Models/User.php',

    ],

    'composer' => [

        'require' => [
            'php' => '^7.3',
            'doctrine/dbal',
            'fideloper/proxy',
            'laravel/horizon',
            'laravel/telescope',
            'laravel/tinker',
            'nesbot/carbon',
            'nothingworks/blade-svg',
            'predis/predis',
            'propaganistas/laravel-fakeid',
            'sebastiaanluca/laravel-auto-morph-map',
            'sebastiaanluca/laravel-boolean-dates',
            'sebastiaanluca/laravel-helpers',
            'sebastiaanluca/laravel-module-loader',
            'sebastiaanluca/laravel-resource-flow',
            'sebastiaanluca/laravel-route-model-autobinding',
            'sebastiaanluca/laravel-router',
            'sebastiaanluca/php-helpers',
            'sebastiaanluca/php-pipe-operator',
            'sentry/sentry-laravel',
            'spatie/data-transfer-object',
            'spatie/laravel-backup',
            'spatie/laravel-blade-x',
            'spatie/laravel-html',
            'spatie/laravel-medialibrary',
            'spatie/laravel-personal-data-export',
            'spatie/laravel-view-models',
            'spatie/once',
            'staudenmeir/eloquent-has-many-deep',
            'webmozart/assert',
        ],

        'require-dev' => [
            'barryvdh/laravel-debugbar',
            'barryvdh/laravel-ide-helper',
            'beyondcode/laravel-dump-server',
            'dms/phpunit-arraysubset-asserts',
            'fzaninotto/faker',
            'itsgoingd/clockwork',
            'kint-php/kint',
            'mockery/mockery',
            'nunomaduro/collision',
            'nunomaduro/larastan',
            'phpunit/phpunit',
            'roave/security-advisories' => 'dev-master',
            'sebastiaanluca/php-codesniffer-ruleset',
            'spatie/laravel-db-snapshots',
            'spatie/phpunit-snapshot-assertions',
            'spatie/test-time',
            'wnx/laravel-stats',
        ],

        'extra' => [
            'laravel' => [
                'dont-discover' => [
                    'laravel/telescope',
                ],
            ],
        ],

        'scripts' => [
            'post-update-cmd' => [
                '@autocomplete',
                '@clear',
            ],
            'post-autoload-dump' => [
                'Illuminate\\Foundation\\ComposerScripts::postAutoloadDump',
                '@php artisan package:discover --ansi',
                '@autocomplete',
                '@clear',
            ],
            'autocomplete' => [
                '@php artisan ide-helper:generate',
                '@php artisan ide-helper:meta',
            ],
            'optimize' => [
                '@php artisan modules:refresh',
                '@autocomplete',
                '@clear',
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
    ],

    'npm' => [

        'dependencies' => [
            'axios' => '~0.19.0',
            'lodash' => '^4.0',
            'svg-injector' => '^1.1',
            'tailwindcss' => '^1.1',
            'tailwindcss-font-variant-numeric' => '~0.1.2',
            'vue' => '^2.6',
            'vue-feather-icons' => '^5.0',
            'vue-template-compiler' => '^2.6.10',
        ],

        'devDependencies' => [
            'browser-sync' => '^2.26',
            'browser-sync-webpack-plugin' => '^2.2',
            'cross-env' => '^5.2',
            'laravel-mix' => '^4.1',
            'laravel-mix-purgecss' => '^4.1',
            'postcss-import' => '^12.0',
            'postcss-nested' => '^4.1',
            'postcss-preset-env' => '^6.7',
        ],

    ],

    'config' => [

        // TODO: copy other configuration files

        'ide-helper',

    ],

];
