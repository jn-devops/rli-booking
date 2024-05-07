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
