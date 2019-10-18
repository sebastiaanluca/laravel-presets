<?php

declare(strict_types=1);

use SebastiaanLuca\Preset\Actions\CleanUpObsoletes;
use SebastiaanLuca\Preset\Actions\ConfigureComposer;
use SebastiaanLuca\Preset\Actions\MoveFramework;
use SebastiaanLuca\Preset\Actions\ScaffoldApplication;
use SebastiaanLuca\Preset\Actions\ScaffoldResources;

return [

    'actions' => [

        'Remove obsolete directories and files' => CleanUpObsoletes::class,
        'Move framework to a sub directory' => MoveFramework::class,
        'Scaffold application' => ScaffoldApplication::class,
        'Scaffold resources' => ScaffoldResources::class,
        'Configure Composer' => ConfigureComposer::class,
        //        'Add Composer packages' => AddComposerPackages::class,
        //        'Add NPM packages' => AddNpmPackages::class,
        //        'Remove preset package' => RemovePresetPackage::class,

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
        'SCRATCH.md',
        'tailwind.config.js',
        'webpack.mix.js',

        'app/Domain',
        'app/Framework',
        'app/Interfaces',
        'app/Modules',

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
            'facade/ignition',
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
            'post-autoload-dump' => [
                'Illuminate\\Foundation\\ComposerScripts::postAutoloadDump',
                '@php artisan package:discover --ansi',
                '@code:autocomplete',
                '@cache:clear',
            ],
            'code:autocomplete' => [
                '@php artisan ide-helper:generate --ansi',
                '@php artisan ide-helper:meta --ansi',
                '@php artisan ide-helper:models --nowrite --ansi',
            ],
            'modules:refresh' => '@php artisan modules:refresh --ansi',
            'assets:publish' => [
                '@php artisan vendor:publish --tag=horizon-assets --force --ansi',
                '@php artisan vendor:publish --tag=telescope-assets --force --ansi',
                '@cache:clear',
            ],
            'cache:clear' => [
                '@php artisan cache:clear --ansi',
                '@php artisan config:clear --ansi',
                '@php artisan route:clear --ansi',
                '@php artisan view:clear --ansi',
                '@php artisan modules:clear --ansi',
                '@php artisan morphmap:clear --ansi',
                '@php artisan autobinding:clear --ansi',
                '@php artisan telescope:clear --ansi',
                '@php artisan clockwork:clean --ansi',
                '@php artisan debugbar:clear --ansi',
            ],
            'session:clear' => '@php artisan cache:clear session --ansi',
            'db:refresh' => '@php artisan migrate:fresh --seed --ansi',
            'db:seed' => '@php artisan db:seed --class=\"ProductionSeeder\" --ansi',
            'app:rebuild' => [
                'composer install --ansi',
                '@db:refresh --ansi',
                '@code:autocomplete --ansi',
                'yarn install',
                'yarn run dev',
                '@cache:clear --ansi',
                '@php artisan search:index',
            ],
            'queue:clear' => '@php artisan cache:clear queue --ansi',
            'queue:restart' => [
                '@php artisan horizon:purge --ansi',
                '@php artisan horizon:terminate --ansi',
                '@php artisan queue:restart --ansi',
            ],
            'lint:check' => 'vendor/bin/phpcs --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1',
            'lint' => 'vendor/bin/phpcbf --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 || exit 0',
            'test:composer' => '@composer validate --no-check-all --strict',
            'test:unit' => 'vendor/bin/phpunit',
            'analyze' => [
                '@test:composer',
                '@lint:check',
            ],
            'test' => [
                '@test:composer',
                '@lint:check',
                '@test:unit',
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

        'ide-helper',

    ],

];
