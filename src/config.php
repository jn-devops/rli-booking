<?php

return [
    'defaults' => [
        'seller' => [
            'email' => env('BOOKING_DEFAULT_SELLER_EMAIL', 'lbhurtado@gmail.com'),
            'mobile' => env('BOOKING_DEFAULT_SELLER_MOBILE', '09178251991')
        ],
        'order' => [
            'webhook' => env('BOOKING_DEFAULT_ORDER_WEBHOOK')
        ],
        'product' => [
            'processing_fee' => env('BOOKING_DEFAULT_PROCESSING_FEE', 10000), //in PHP
            'auto' => [
                'PHH1' => [
                    'location' => 'Cavite',
                    'category' => 'Extraordinary, Pasinaya Homes',
                    'brand' => 'Pasinaya Homes Hilaga',
                ],
            ],
        ],
        'url' => [
            'campaign' => env('BOOKING_DEFAULT_CAMPAIGN_URL', 'https://kwyc-check.net/campaign-checkin/9b1827c4-f374-443d-97e7-58a28043c6ac')
        ],
    ],
    'seeds' => [
        'sellers' => [
            'admin' => [
                'name' => config('app.name') . ' Admin',
                'email' => env('BOOKING_ADMIN_EMAIL', 'devops@joy-nostalg.com'),
                'mobile' => env('BOOKING_ADMIN_MOBILE', '09173011987'),
                'password' => env('BOOKING_ADMIN_PASSWORD', '#Password1'),
                'password_confirmation' => env('BOOKING_ADMIN_PASSWORD', '#Password1'),
            ],
            'broker' => [],
            'manager' => [],
            'agent' => []
        ],
    ],
    'webhook' => [
        'client_secret' => env('WEBHOOK_CLIENT_SECRET'),
        'customer_header' => env('WEBHOOK_CUSTOMER_HEADER'),
        'entity_type' => env('WEBHOOK_ENTITY_TYPE'),
    ],
    'bitly' => [
        'server' => [
            'shorten_end_point' => env('BITLY_SERVER_SHORTEN_END_POINT'),
            'update_end_point' => env('BITLY_SERVER_UPDATE_END_POINT'),
        ],
        'client' => [
            'token' => env('BITLY_CLIENT_TOKEN'),
            'group_guid' => env('BITLY_CLIENT_GROUP_GUID'),
            'domain' => env('BITLY_CLIENT_DOMAIN'),
        ],
    ],
];
