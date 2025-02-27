<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use App\Enums\LanguageCodes;

class NewsApiOrgService extends BaseNewsService
{
    protected string $apiSourceId = ApiSources::NEWSAPIORG->value;
    protected array $apiSourceConfig;
    public function __construct()
    {
        $this->apiSourceConfig = config("global.news.$this->apiSourceId");
    }

    public function fetchArticles(
        string $path = '/v2/top-headlines',
        int $page = 1,
        string $query = null,
        LanguageCodes $languageCode = LanguageCodes::EN,
    ): array {

        return $this->callApi($path, $this->buildQueryParams($query, $page, $languageCode), $resultKey = 'articles');
    }

    private function buildQueryParams(?string $query, ?int $page, ?LanguageCodes $languageCode): array
    {
        return array_filter([
            'apiKey' => $this->apiSourceConfig['api_key'],
            'from' => now()->subDays($this->apiSourceConfig['days_ago'])->toIso8601String(), // Default: articles from the last 2 days
            'language' => $languageCode->value,
            'page' => $page,
            'q' => $query,
        ], fn($value) => $value !== null);
    }
}
