<?php

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Session\Store;

return [

    'format' => 'php',
    'filename' => '_ide_helper',
    'meta_filename' => '.phpstorm.meta.php',

    'include_fluent' => true,
    'write_model_magic_where' => true,
    'include_helpers' => true,

    'helper_files' => [
        base_path() . '/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
        base_path() . '/vendor/laravel/framework/src/Illuminate/Foundation/helpers.php',
        base_path() . '/vendor/spatie/laravel-html/src/helpers.php',
        base_path() . '/vendor/sebastiaanluca/laravel-helpers/src/Methods/helpers.php',
    ],

    'model_locations' => [
        'app',
    ],

    'extra' => [
        'Eloquent' => [
            EloquentBuilder::class,
            QueryBuilder::class,
        ],
        'Session' => [
            Store::class,
        ],
    ],

    'magic' => [
        'Log' => [
            'debug' => 'Monolog\Logger::addDebug',
            'info' => 'Monolog\Logger::addInfo',
            'notice' => 'Monolog\Logger::addNotice',
            'warning' => 'Monolog\Logger::addWarning',
            'error' => 'Monolog\Logger::addError',
            'critical' => 'Monolog\Logger::addCritical',
            'alert' => 'Monolog\Logger::addAlert',
            'emergency' => 'Monolog\Logger::addEmergency',
        ],
    ],

    'interfaces' => [],

    'model_camel_case_properties' => false,

    'custom_db_types' => [
        'mysql' => [
            'json' => 'json_array',
        ],
    ],

    'type_overrides' => [
        'integer' => 'int',
        'boolean' => 'bool',
    ],

];
