<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Encryption Keys
    |--------------------------------------------------------------------------
    |
    | Passport uses encryption keys while generating secure access tokens for
    | your application. By default, the keys are stored as local files but
    | can be set via environment variables when that is more convenient.
    |
    */

    'private_key' => env('PASSPORT_PRIVATE_KEY'),

    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Name
    |--------------------------------------------------------------------------
    |
    | This Passport middleware will attach a laravel_token cookie to your outgoing
    | responses. This cookie contains an encrypted JWT that Passport will use to
    | authenticate API requests from your JavaScript application. Now, you may make
    | requests to your application's API without explicitly passing an access token.
    |
    */

    'cookie_name' => env(
        'PASSPORT_COOKIE_NAME',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_passport'
    ),

];
