<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use App\Enums\LanguageCodes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Contracts\NewsServiceInterface;

class TheGuardianService implements NewsServiceInterface
{
    private string $apiSourceId = ApiSources::THEGUARDIAN->value;
    private array $apiSourceConfig;
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

        return $this->callApi($path, $this->buildQueryParams($query, $page, $languageCode));
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
                throw new \Exception('Failed to fetch articles from API:'.$this->apiSourceId);
            }

            return $response->json('response.results') ?? [];

        } catch (\Exception $e) {

            Log::error('Error fetching articles', ['message' => $e->getMessage(),'source_api' => $this->apiSourceId]);
            return [];
        }
    }
}
