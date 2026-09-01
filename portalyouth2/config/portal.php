<?php

return [

    'name' => env('PORTAL_NAME', 'Zimbabwe Youth Portal'),

    'translation_locales' => ['ny', 'bwg', 'en', 'kck', 'kho', 'nmq', 'ndau', 'nde', 'tso', 'sn', 'st', 'toi', 'tn', 've', 'xh'],
    'nllb_locales' => ['ny', 'nde', 'sn', 'st', 'tso', 'tn', 've', 'xh'],
    'nllb_url' => env('NLLB_TRANSLATE_URL', 'http://127.0.0.1:8090/translate'),
    'nllb_timeout' => (int) env('NLLB_TRANSLATE_TIMEOUT', 120),

    'ministry' => 'Ministry of Youth Empowerment, Development and Vocational Training',

    'email' => env('PORTAL_EMAIL', 'info@youth.gov.zw'),

    'phones' => [
        env('PORTAL_PHONE_1', '+263 242 707742 / 708678'),
        env('PORTAL_PHONE_2', '+263 71 217 7113'),
    ],

    'address' => 'Old Parliament Building, Kwame Nkrumah & Third St, Harare ZW',

    'social' => [
        'twitter' => env('SOCIAL_TWITTER', 'https://x.com/myedvt'),
        'facebook' => env('SOCIAL_FACEBOOK', 'https://www.facebook.com/myedvt'),
        'whatsapp' => env('SOCIAL_WHATSAPP'),
        'youtube' => env('SOCIAL_YOUTUBE'),
        'instagram' => env('SOCIAL_INSTAGRAM'),
        'linkedin' => env('SOCIAL_LINKEDIN'),
    ],

    'related_links' => [
        [
            'label' => 'EmpowerBank',
            'url' => 'https://www.empowerbank.co.zw/',
        ],
        [
            'label' => 'Zimbabwe Youth Council',
            'url' => 'https://www.facebook.com/zimbayouth',
        ],
        [
            'label' => 'National Youth Policy',
            'url' => 'https://zgc.co.zw/wp-content/uploads/2022/10/NATIONAL-YOUTH-POLICY-2020-2025.pdf',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Remote image proxying
    |--------------------------------------------------------------------------
    |
    | Official imagery is hotlinked from the ministry website but served through
    | a local caching proxy so a slow or unreachable upstream never blocks the
    | portal. Disable to render remote URLs directly.
    */

    'image_cache' => [
        'enabled' => env('IMAGE_CACHE_ENABLED', true),
        'ttl_seconds' => (int) env('IMAGE_CACHE_TTL', 604800),
        'timeout_seconds' => (int) env('IMAGE_CACHE_TIMEOUT', 8),
        'max_bytes' => (int) env('IMAGE_CACHE_MAX_BYTES', 5242880),
    ],

    /*
    |--------------------------------------------------------------------------
    | Campaign emergency contacts (drug & substance abuse support)
    |--------------------------------------------------------------------------
    */

    'drug_helpline' => env('DRUG_HELPLINE', '+263 71 217 7113'),

];
