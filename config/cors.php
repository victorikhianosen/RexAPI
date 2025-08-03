<?php

$allowedOrigins = explode(',', env('CORS_ALLOWED_ORIGINS', '*'));

return [
    'paths' => ['api/*', 'business/*', 'admin/*'],  // routes where CORS applies

    'allowed_methods' => ['*'],                      // allow all HTTP methods

    'allowed_origins' => $allowedOrigins,            // origins allowed, comma-separated in .env or '*' for all

    'allowed_headers' => ['*'],                       // allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
