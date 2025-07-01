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
    'stripe' => [
        'secret' => 'sk_test_u9FDGnChLD9i5gF4iY2kaZ4300y4xKOfJk',
    ],

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
       'nexmo' => [
    'sms_from' => 'Vonage SMS API',
    ],
    
    'twitter' => [
            'client_id'     => env('TWITTER_CLIENT_ID'),
            'client_secret' => env('TWITTER_CLIENT_SECRET'),
            'redirect'      => env('TWITTER_URL'),
        ],
        
    'country_ip_check' => env('CountryIPcheck'),

    'apple' => [
        'shared_secret' => env('APPLE_SHARED_SECRET'),
        'server_notification_url' => env('APPLE_SERVER_NOTIFICATION_URL', 'https://runmawi.com/api/auth/apple_server_notification'),
    ],

];
