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
    "sms" => [
        "provider" => env('SMS_PROVIDER'),
        "uri" => "https://ippanel.com/services.jspd",
        "auth" => [
            "uname" => env("SMS_USERNAME"),
            "pass" => env("SMS_PASS"),
        ],
        "service_number" => env("SMS_NUMBER_WITH_LINK"),
        "advertisement_number" => env("SMS_NUMBER_WITHOUT_LINK")
    ],
    'kavenegar' => [
        'key' => env('72524D7557443837367938784773627A7167596C2B4F336468336E6759562B504B492B67536475376B566B3D'),
        'sender' => env('10001110010010')
    ],
];
