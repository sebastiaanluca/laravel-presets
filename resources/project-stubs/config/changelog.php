<?php

return [

    'file' => base_path('CHANGELOG.md'),

    'route' => [
        'name' => 'changelog.index',
        'url' => 'internal/updates',
    ],

    'view' => null,

    'cache' => true,
    'cache_duration' => INF,
    'cache_key' => 'changelog',

];
