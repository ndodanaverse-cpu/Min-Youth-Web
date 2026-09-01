<?php

return [

    /*
    |--------------------------------------------------------------------------
    | One-time password configuration
    |--------------------------------------------------------------------------
    */

    'digits' => (int) env('OTP_DIGITS', 6),

    'ttl' => (int) env('OTP_TTL_MINUTES', 10) * 60,

    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),

    'resend_cooldown' => (int) env('OTP_RESEND_COOLDOWN_SECONDS', 60),

    'code_store_ttl_minutes' => 30,

    /*
    |--------------------------------------------------------------------------
    | Default delivery channel
    |--------------------------------------------------------------------------
    |
    | Supported: "email", "sms". Users can always request a resend through the
    | alternative channel from the verification screen.
    */

    'default_channel' => env('OTP_DEFAULT_CHANNEL', 'email'),

    'channels' => [
        'email' => env('OTP_CHANNEL_EMAIL', true),
        'sms' => env('OTP_CHANNEL_SMS', true),
    ],

];
