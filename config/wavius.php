<?php

/**
 * Wavius Configuration
 * 
 * Configuration file for the Wavius WhatsApp Laravel SDK.
 * Contains all the necessary settings for API communication and package behavior.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Wavius WhatsApp API endpoints and authentication.
    |
    */
    'api' => [
        'base_url' => env('WAVIUS_API_BASE_URL', 'https://api.wavius.co'),
        'version' => env('WAVIUS_API_VERSION', 'v1'),
        'timeout' => env('WAVIUS_API_TIMEOUT', 30),
        'retry_attempts' => env('WAVIUS_API_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('WAVIUS_API_RETRY_DELAY', 1000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Authentication settings for the Wavius API.
    |
    */
    'auth' => [
        'token' => env('WAVIUS_API_TOKEN'),
        'token_header' => env('WAVIUS_TOKEN_HEADER', 'Authorization'),
        'token_prefix' => env('WAVIUS_TOKEN_PREFIX', 'Bearer'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Instance Configuration
    |--------------------------------------------------------------------------
    |
    | Default instance settings and behavior.
    |
    */
    'instance' => [
        'default_id' => env('WAVIUS_DEFAULT_INSTANCE_ID'),
        'auto_connect' => env('WAVIUS_AUTO_CONNECT', false),
        'connection_timeout' => env('WAVIUS_CONNECTION_TIMEOUT', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Webhook settings for receiving WhatsApp events.
    |
    */
    'webhook' => [
        'enabled' => env('WAVIUS_WEBHOOK_ENABLED', false),
        'secret' => env('WAVIUS_WEBHOOK_SECRET'),
        'endpoint' => env('WAVIUS_WEBHOOK_ENDPOINT', '/webhooks/wavius'),
        'verify_signature' => env('WAVIUS_VERIFY_WEBHOOK_SIGNATURE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | Queue settings for message processing.
    |
    */
    'queue' => [
        'enabled' => env('WAVIUS_QUEUE_ENABLED', true),
        'connection' => env('WAVIUS_QUEUE_CONNECTION', 'default'),
        'queue_name' => env('WAVIUS_QUEUE_NAME', 'wavius'),
        'retry_after' => env('WAVIUS_QUEUE_RETRY_AFTER', 90),
        'tries' => env('WAVIUS_QUEUE_TRIES', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Logging settings for debugging and monitoring.
    |
    */
    'logging' => [
        'enabled' => env('WAVIUS_LOGGING_ENABLED', true),
        'channel' => env('WAVIUS_LOG_CHANNEL', 'stack'),
        'level' => env('WAVIUS_LOG_LEVEL', 'info'),
        'log_requests' => env('WAVIUS_LOG_REQUESTS', false),
        'log_responses' => env('WAVIUS_LOG_RESPONSES', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Route settings for the package endpoints.
    |
    */
    'routes' => [
        'prefix' => env('WAVIUS_ROUTES_PREFIX', 'api/v1'),
        'middleware' => [
            'api',
            'throttle:60,1',
        ],
        'auth_middleware' => [
            'wavius.auth',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for storing API responses and data.
    |
    */
    'cache' => [
        'enabled' => env('WAVIUS_CACHE_ENABLED', true),
        'ttl' => env('WAVIUS_CACHE_TTL', 3600), // 1 hour
        'prefix' => env('WAVIUS_CACHE_PREFIX', 'wavius'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    |
    | Media upload and storage settings.
    |
    */
    'media' => [
        'storage_disk' => env('WAVIUS_MEDIA_STORAGE_DISK', 'local'),
        'max_file_size' => env('WAVIUS_MAX_FILE_SIZE', 16777216), // 16MB
        'allowed_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'video/mp4',
            'video/3gpp',
            'audio/mp3',
            'audio/ogg',
            'audio/wav',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting settings for API requests.
    |
    */
    'rate_limiting' => [
        'enabled' => env('WAVIUS_RATE_LIMITING_ENABLED', true),
        'requests_per_minute' => env('WAVIUS_RATE_LIMIT_PER_MINUTE', 60),
        'burst_limit' => env('WAVIUS_RATE_LIMIT_BURST', 10),
    ],
];
