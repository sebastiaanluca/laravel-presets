<?php

return [

    'libraries' => [],

    'dev_libraries' => [

        'kint-php/kint',
        'orchestra/testbench',
        'mockery/mockery',
        'nunomaduro/collision',
        'phpunit/phpunit',
        'sebastiaanluca/php-codesniffer-ruleset',

    ],

    'composer_scripts' => [

        'test-lowest' => [
            'composer update --prefer-lowest --prefer-dist --no-interaction --ansi',
            '@test',
        ],
        'test-stable' => [
            'composer update --prefer-stable --prefer-dist --no-interaction --ansi',
            '@test',
        ],

    ],

];
