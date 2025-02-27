<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;

class NewYorkTimesService extends BaseNewsService
{
    protected string $apiSourceId = ApiSources::NEWYORKTIMES->value;
    protected array $apiSourceConfig;

    public function __construct()
    {
        $this->apiSourceConfig = config("global.news.$this->apiSourceId");
    }

    public function fetchArticles(string $path = '/svc/search/v2/articlesearch.json'): array
    {
        return $this->callApi($path, $this->buildQueryParams(), $resultKey = 'response.docs');
    }

    private function buildQueryParams(): array
    {
        return [
            'api-key' => $this->apiSourceConfig['api_key'],
            'begin_date' => now()->subDays($this->apiSourceConfig['days_ago'])->format('Ymd'),
        ];
    }
}
