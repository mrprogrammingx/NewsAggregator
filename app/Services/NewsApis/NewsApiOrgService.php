<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use App\Enums\LanguageCodes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Contracts\NewsServiceInterface;

class NewsApiOrgService implements NewsServiceInterface
{
    private string $apiSourceId = ApiSources::NEWSAPIORG->value;
    private array $apiSourceConfig;
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

        return $this->callApi($path, $this->buildQueryParams($query, $page, $languageCode));
    }

    private function buildQueryParams(?string $query, ?int $page, ?LanguageCodes $languageCode): array
    {
        return [
            'apiKey' => $this->apiSourceConfig['api_key'],
            'from' => now()->subDays($this->apiSourceConfig['days_ago'])->toIso8601String(), // Default: articles from the last 2 days
            'language' => $languageCode->value,
            'page' => $page,
            'q' => $query,
        ];
    }

    public function callApi(?string $path, ?array $queryParams): array
    {
        try {

            $response = Http::get($this->apiSourceConfig['base_url'] . $path, $queryParams);

            if ($response->failed()) {
                Log::error('Failed to fetch articles', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'source_api' => $this->apiSourceId,
                ]);
                throw new \Exception('Failed to fetch articles from API:' . $this->apiSourceId);
            }

            return $response->json('articles') ?? [];
        } catch (\Exception $e) {
            Log::error('Error fetching articles', ['message' => $e->getMessage(), 'source_api' => $this->apiSourceId]);
            return [];
        }
    }
}
