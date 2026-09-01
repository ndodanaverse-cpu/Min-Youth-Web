<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default SMS driver
    |--------------------------------------------------------------------------
    |
    | Supported: "log", "twilio"
    |
    | The "log" driver writes messages to the application log which is ideal
    | for local development. Additional providers can be added by implementing
    | the App\Services\Sms\Contracts\SmsSender contract and registering the
    | driver in AppServiceProvider.
    |
    */

    'default' => env('SMS_DRIVER', 'log'),

    'from' => env('SMS_FROM', 'YouthGov'),

    'drivers' => [
        'log' => [
            'channel' => env('SMS_LOG_CHANNEL', 'stack'),
        ],

        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM', env('SMS_FROM', 'YouthGov')),
        ],
    ],

];
