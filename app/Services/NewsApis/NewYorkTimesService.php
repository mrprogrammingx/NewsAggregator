<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Contracts\NewsServiceInterface;

class NewYorkTimesService implements NewsServiceInterface
{
    private string $apiSourceId = ApiSources::NEWYORKTIMES->value;
    private array $apiSourceConfig;

    public function __construct()
    {
        $this->apiSourceConfig = config("global.news.$this->apiSourceId");
    }

    public function fetchArticles(string $path = '/svc/search/v2/articlesearch.json'): array
    {
        return $this->callApi($path, $this->buildQueryParams());
    }

    private function buildQueryParams(): array
    {
        return [
            'api-key' => $this->apiSourceConfig['api_key'],
            'begin_date' => now()->subDays($this->apiSourceConfig['days_ago'])->format('Ymd'),
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

            return $response->json('response.docs') ?? [];

        } catch (\Exception $e) {

            Log::error('Error fetching articles', ['message' => $e->getMessage(), 'source_api' => $this->apiSourceId]);
            return [];
        }
    }
}
