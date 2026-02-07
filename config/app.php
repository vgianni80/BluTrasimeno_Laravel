<?php

return [
    'name' => env('APP_NAME', 'Gestione Prenotazioni'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Europe/Rome',
    'locale' => env('APP_LOCALE', 'it'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'it'),
    'faker_locale' => 'it_IT',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [...array_filter(explode(',', env('APP_PREVIOUS_KEYS', '')))],
    'maintenance' => ['driver' => env('APP_MAINTENANCE_DRIVER', 'file')],
];
