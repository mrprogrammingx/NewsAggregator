<?php

use App\Enums\ApiSources;

return [
    'news' => array_reduce(
        ApiSources::cases(),
        function ($carry, $source) {
            $carry[$source->value] = [
                'api_key' => env(strtoupper($source->value) . '_KEY') ?: 'test',
                'base_url' => env(strtoupper($source->value) . '_BASE_URL', 'default_url'),
                'timeout' => env(strtoupper($source->value) . '_TIMEOUT', 30),
                'active' => env(strtoupper($source->value) . '_KEY', false) !== false,
                'max_content' => 1024,
                'days_ago' => 2, //default days ago to collect news
            ];
            return $carry;
        },
        []
    ),
    'articles' => [
        'pagination' => [
            'default_per_page' => 10
        ]
    ]
];

