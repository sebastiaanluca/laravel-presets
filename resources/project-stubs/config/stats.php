<?php

use Wnx\LaravelStats\RejectionStrategies\RejectVendorClasses;

return [

    'paths' => [
        base_path('app'),
        base_path('config'),
        base_path('database'),
        base_path('modules'),
        base_path('tests'),
    ],

    'exclude' => [
        base_path('tests/bootstrap.php'),
        // base_path('app/helpers.php'),
        // base_path('app/Services'),
    ],

    'custom_component_classifier' => [
        // \App\Classifiers\CustomerExportClassifier::class
    ],

    'rejection_strategy' => RejectVendorClasses::class,

    'ignored_namespaces' => [
        'Wnx\LaravelStats',
        'Illuminate',
        'Symfony',
    ],

];
