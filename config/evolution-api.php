<?php

declare(strict_types=1);

return [
    'base_url' => env('EVOLUTION_API_BASE_URL', 'https://api.evolution.com'),
    'api_key' => env('EVOLUTION_API_KEY'),
    'timeout' => env('EVOLUTION_API_TIMEOUT', 30),
    'default_instance' => env('EVOLUTION_API_DEFAULT_INSTANCE'),
];
