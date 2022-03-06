<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '701402369317-7r0eaopn63fe4tdn37c45tg52fec8avu.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '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'),
        'redirect' => env('GOOGLE_REDIRECT', 'http://localhost:8000/api/login/google/callback')
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '2032050810306961'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '31b86a303817e6b26319181ca8403ee1'),
        'redirect' => env('FACEBOOK_REDIRECT', 'http://localhost:8000/api/login/facebook/callback')
    ],


];
