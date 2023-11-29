<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'fcm' => [
        'key' => 'AAAAPmvY334:APA91bEFsWqRQiL59FAdOUCU9BwhVodUtFwsAPkg9poDPM3DXWkU_fCHjPQHjMpDjXW-j2HReQOtp2q-OQn5cUyvI5pDTgcVGEc9ZFMfERLIttCMDhSbUarZy7wmye0QDjxTnGnhyR2lYvNivuvZHM0r-San4cKJXA'
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
