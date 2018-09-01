<?php 

return [
    "sms" => [
        "smsir" => [
            "uri" => env('SMSIR_URI'),
            "token" => env('SMSIR_TOKEN'),
            "api_key" => env('SMSIR_API_KEY'),
            "line_number" => env('SMSIR_LINE_NUMBER'),
            "secret_key" => env('SMSIR_SECRET_KEY')
        ],
        "sms0098" => [
            "from" => env("SMS0098_FROM"),
            "username" => env("SMS0098_USERNAME"),
            "password" => env("SMS0098_PASSWORD"),
        ]
    ],
    "push" => [
        "onesignal" => [
            "uri" => env('ONESIGNAL_URI'),
            "app_id" => env('ONESIGNAL_APP_ID'),
            "authorization" => env('ONESIGNAL_AUTHORIZATION')
        ],
        "chabok" => [
            "uri_dev" => env('CHABOK_URI_DEV'),
            "uri" => env('CHABOK_URI'),
            "app_id" => env('CHABOK_APP_ID'),
            "access_token" => env('CHABOK_ACCESS_TOKEN')
        ]
    ],

    
    "sms_providers_priority" => env('SMS_PROVIDERS_PRIORITY'),
    "push_providers_priority" => env('PUSH_PROVIDERS_PRIORITY')
];