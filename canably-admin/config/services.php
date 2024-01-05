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

    'storage' => [
        'disk' => env('FILE_STORAGE_DISK')
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'notifications' => [
        'email'                 => env('SITE_EMAIL_NOTIFICATION_SEND', true),
        'text'                  => env('SITE_TEXT_NOTIFICATION_SEND', false),
        'inApp'                 => env('SITE_INAPP_NOTIFICATION_SEND', true),
    ],

    'fileUploadPaths' => [
        'adminDocumentPath'      => 'documents/',
        'adminOriginalImagePath' => 'images/original/',
        'adminPostVideoPath'     => 'videos/',
        'customerImageUploadPath' => 'images/original/user/'
    ],

    'email_configuration' => [
        'site_mail_from'           => env('MAIL_FROM_ADDRESS', 'soumyajit.ball@shyamfuture.com'),
        'site_reply_to'            => env('SITE_REPLY_TO', 'soumyajit.ball@shyamfuture.com'),
        'site_mail_greetings'      => env('SITE_MAIL_GREETINGS', 'Regards,'),
        'site_mail_greetings_from' => env('SITE_MAIL_GREETINGS_FROM', 'CANABLY'),
        'site_name'                  => env('SITE_NAME', 'CANABLY'),
        'site_url_for_mail'          => env('SITE_URL_FOR_MAIL', 'CANABLY'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'secret' => env('STRIPE_SECRET_KEY',false),
        'publish' => env('STRIPE_PUBLISH_KEY',false),
    ]

];
