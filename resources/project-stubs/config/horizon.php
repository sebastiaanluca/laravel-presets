<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Str;

return [

    'domain' => null,

    'path' => 'internal/horizon',

    'use' => 'queue',

    'prefix' => env('HORIZON_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . ':horizon:'),

    'middleware' => [
        'web',
        Authenticate::class,
    ],

    'waits' => [
        'redis:default' => 60,
    ],

    'trim' => [
        'recent' => 60 * 24,
        'recent_failed' => 60 * 24 * 7,
        'failed' => 60 * 24 * 30,
        'monitored' => 60 * 24 * 7,
    ],

    'fast_termination' => false,

    'memory_limit' => 64,

    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => [
                    'default',
                    'notifications',
                    'listeners',
                    'media',
                ],
                'balance' => 'simple',
                'processes' => 3,
                'tries' => 3,
            ],
        ],

        'staging' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => [
                    'default',
                    'notifications',
                    'listeners',
                    'media',
                ],
                'balance' => 'simple',
                'processes' => 1,
                'tries' => 1,
            ],
        ],

        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => [
                    'default',
                    'notifications',
                    'listeners',
                    'media',
                ],
                'balance' => 'simple',
                'processes' => 1,
                'tries' => 1,
            ],
        ],
    ],
];
