<?php

return [
    'pagination' => [
        'per_page' => env('API_PER_PAGE', 15),
        'max_per_page' => env('API_MAX_PER_PAGE', 100),
    ],

    'rate_limit' => [
        'max_attempts' => env('API_RATE_LIMIT', 60),
        'decay_minutes' => env('API_RATE_LIMIT_DECAY', 1),
    ],
];

