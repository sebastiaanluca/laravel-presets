<?php

return [

    'enabled' => env('DEBUGBAR_ENABLED', false),

    'except' => [
        'horizon*',
        'telescope*',
        'clockwork*',
    ],

    'storage' => [
        'enabled' => true,
        'driver' => 'file',
        'path' => storage_path('debugbar'),
        'connection' => null,
        'provider' => '',
    ],

    'include_vendors' => true,

    'capture_ajax' => true,
    'add_ajax_timing' => false,

    'error_handler' => false,
    'clockwork' => false,

    'collectors' => [
        'phpinfo' => true,
        'messages' => true,
        'time' => true,
        'memory' => true,
        'exceptions' => true,
        'log' => true,
        'db' => true,
        'views' => true,
        'route' => true,
        'auth' => true,
        'gate' => true,
        'session' => true,
        'symfony_request' => true,
        'mail' => true,
        'laravel' => false,
        'events' => true,
        'default_request' => false,
        'logs' => true,
        'files' => false,
        'config' => false,
        'cache' => false,
        'models' => true,
    ],

    'options' => [
        'auth' => [
            'show_name' => true,
        ],
        'db' => [
            'with_params' => true,
            'backtrace' => true,
            'timeline' => false,
            'explain' => [
                'enabled' => false,
                'types' => ['SELECT'],
            ],
            'hints' => true,
        ],
        'mail' => [
            'full_log' => false,
        ],
        'views' => [
            'data' => false,
        ],
        'route' => [
            'label' => true,
        ],
        'logs' => [
            'file' => null,
        ],
        'cache' => [
            'values' => true,
        ],
    ],

    'inject' => true,

    'route_prefix' => '_debugbar',

    'route_domain' => null,

];
