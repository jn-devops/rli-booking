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
];
