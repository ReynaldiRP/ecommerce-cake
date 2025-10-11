<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Seeder Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for database seeders to ensure
    | consistent and secure data generation across different environments.
    |
    */

    'passwords' => [
        /*
        |--------------------------------------------------------------------------
        | Default Passwords
        |--------------------------------------------------------------------------
        |
        | Default passwords for different user types. In production, these should
        | be generated randomly and stored securely.
        |
        */
        'owner' => env('OWNER_DEFAULT_PASSWORD', 'SecureOwnerPass123!'),
        'admin' => env('ADMIN_DEFAULT_PASSWORD', 'SecureAdminPass123!'),
        'customer' => env('CUSTOMER_DEFAULT_PASSWORD', 'customer123'),
    ],

    'users' => [
        /*
        |--------------------------------------------------------------------------
        | User Generation Settings
        |--------------------------------------------------------------------------
        |
        | Settings for generating realistic user data
        |
        */
        'customer_count' => env('SEEDER_CUSTOMER_COUNT', 20),
        'verify_emails' => env('SEEDER_VERIFY_EMAILS', true),
    ],

    'orders' => [
        /*
        |--------------------------------------------------------------------------
        | Order Generation Settings
        |--------------------------------------------------------------------------
        |
        | Settings for generating realistic order data
        |
        */
        'count' => env('SEEDER_ORDER_COUNT', 150),
        'date_range_months' => env('SEEDER_ORDER_DATE_RANGE', 6),
    ],

    'security' => [
        /*
        |--------------------------------------------------------------------------
        | Security Settings
        |--------------------------------------------------------------------------
        |
        | Security-related settings for seeders
        |
        */
        'production_safe' => env('SEEDER_PRODUCTION_SAFE', false),
        'log_actions' => env('SEEDER_LOG_ACTIONS', true),
        'use_transactions' => env('SEEDER_USE_TRANSACTIONS', true),
    ],

    'domains' => [
        /*
        |--------------------------------------------------------------------------
        | Email Domains
        |--------------------------------------------------------------------------
        |
        | Allowed email domains for generated user accounts
        |
        */
        'business' => [
            'cakestore.local',
            'bakery.local',
        ],
        'customer' => [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'outlook.com',
            'yahoo.co.id',
            'live.com',
        ],
    ],
];
