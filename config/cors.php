<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000', 'http://localhost:3001', 'http://localhost:3007', 'http://localhost:3008', 'http://localhost:4008', 'http://localhost:5174', 'http://localhost:5173', 'http://localhost:5175', 'http://100.89.150.50:3000', 'http://100.89.150.50:3007', 'http://100.89.150.50:3008', 'http://100.89.150.50:4008', 'http://100.89.150.50:5174', 'http://192.168.1.152:3000', 'http://192.168.1.152:3008', 'https://task.az', 'https://www.task.az', 'https://task.az', 'https://www.task.az'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
