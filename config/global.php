<?php

use App\Enums\ApiSources;

return [
    'news' => array_reduce(
        ApiSources::cases(),
        function ($carry, $source) {
            $carry[$source->value] = [
                'api_key' => env(strtoupper($source->value) . '_KEY') ?: 'test',//throw new InvalidArgumentException("API key for {$source->name()} is not set."),
                'base_url' => env(strtoupper($source->value) . '_BASE_URL', 'default_url'),
                'timeout' => env(strtoupper($source->value) . '_TIMEOUT', 30),
            ];
            return $carry;
        },
        []
    ),
];

