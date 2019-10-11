<?php

use Illuminate\Support\Str;

return [

    'default' => env('CACHE_DRIVER', 'redis'),

    'stores' => [

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        /*
         * Custom
         */

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],

        'redis-default' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'session' => [
            'driver' => 'redis',
            'connection' => 'session',
        ],

        'horizon' => [
            'driver' => 'redis',
            'connection' => 'queue',
        ],

    ],

    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache'),

];
