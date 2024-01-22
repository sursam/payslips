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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'email_configuration' => [
        'site_mail_from' => env('MAIL_FROM_ADDRESS'),
        'site_reply_to' => env('MAIL_FROM_ADDRESS'),
        'site_mail_greetings' => '',
        'site_mail_greetings_from' => env('MAIL_FROM_NAME'),
    ],
    'sms' => [
        'username' => env('SMS_GATEWAY_USER'),
        'password' => env('SMS_GATEWAY_PASS'),
        'sender' => env('SMS_SENDER_ID'),
    ],
    'firebase' => [
        'apiKey' => env('FIREBASE_API_KEY'),
        'authDomain' => env('FIREBASE_AUTH_DOMAIN'),
        'projectId' => env('FIREBASE_PROJECT_ID'),
        'storageBucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => env('FIREBASE_APP_ID'),
        'measurementId' => env('FIREBASE_MEASUREMENT_ID'),
    ],
    'apple' => [
        'phone_no' => env('APPLE_PHONE_NO'),
        'otp' => env('APPLE_OTP'),
    ],
    'google' => [
        'phone_no' => env('GOOGLE_PHONE_NO'),
        'otp' => env('GOOGLE_OTP'),
    ]
];
