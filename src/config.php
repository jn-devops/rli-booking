<?php

return [
    'defaults' => [
        'seller' => [
            'email' => env('BOOKING_DEFAULT_SELLER_EMAIL')
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
];
