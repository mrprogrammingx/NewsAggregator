<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use App\Enums\LanguageCodes;

class TheGuardianService extends BaseNewsService
{
    protected string $apiSourceId = ApiSources::THEGUARDIAN->value;
    protected array $apiSourceConfig;
    public function __construct()
    {
        $this->apiSourceConfig = config("global.news.$this->apiSourceId");
    }

    public function fetchArticles(
        string $path = '/search',
        int $page = 1,
        string $query = null,
        LanguageCodes $languageCode = LanguageCodes::EN,
        ): array
    {

        return $this->callApi($path, $this->buildQueryParams($query, $page, $languageCode), $resultKey = 'response.results');
    }

    private function buildQueryParams(?string $query, ?int $page, ?LanguageCodes $languageCode): array
    {
        return [
            'api-key' => $this->apiSourceConfig['api_key'],
            'page' => $page,
            'q' => $query,
            'lang' => $languageCode,
            'show-references' => 'author',
            'show-fields' => 'bodyText',
            'from-date' => now()->subDays($this->apiSourceConfig['days_ago'])->format('Y-m-d'),
        ];
    }
}
