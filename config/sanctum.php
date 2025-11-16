<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Requests from the following domains / hosts will receive stateful API
    | authentication cookies. Typically, these should include your local
    | and production frontends that need Sanctum session support.
    |
    */

    'stateful' => array_filter(
        explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
            'localhost,localhost:3000,localhost:4200,127.0.0.1,127.0.0.1:8000,%s',
            parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)
        )))
    ),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Here you may specify the authentication guards that should be checked
    | when Sanctum is trying to authenticate a request. Typically, this
    | will simply be "web" but you may define whatever is needed.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | considered expired. If this value is null, personal access tokens do
    | not expire. This won't affect first-party session based auth.
    |
    */

    'expiration' => env('SANCTUM_EXPIRATION', 60 * 24),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | When authenticating your first-party SPA with Sanctum you may need to
    | customize some of the middleware Sanctum uses. You may change the
    | middleware listed below as required to suit your application.
    |
    */

    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];

