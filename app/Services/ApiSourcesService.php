<?php

namespace App\Services;

use App\Contracts\ApiSourcesServiceInterface;
use App\Enums\ApiSources;

class ApiSourcesService implements ApiSourcesServiceInterface
{
    public function allIds(): array
    {
        return ApiSources::cases();
    }
    public function getActiveIds(): array
    {
        return array_keys(
            array_filter(
                config('global.news'),
                fn($item) => $item['active'] === true
            )
        );
    }

    public function getServiceName(string $apiSourceId): string
    {
        return 'App\Services\NewsApis\\' . ApiSources::serviceClassName($apiSourceId);
    }

}
