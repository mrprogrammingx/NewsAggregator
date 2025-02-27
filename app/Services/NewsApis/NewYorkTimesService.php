<?php

namespace App\Services\NewsApis;

use App\Enums\ApiSources;
use App\Exceptions\ApiException;
use App\Traits\ErrorLogTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Contracts\NewsServicesInterface;

class NewYorkTimesService implements NewsServicesInterface
{
    use ErrorLogTrait;

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

                $this->logError('Failed to fetch articles', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'source_api' => $this->apiSourceId,
                ]);

                throw new ApiException('Failed to fetch articles from API:' . $this->apiSourceId);
            }

            return $response->json('response.docs') ?? [];

        } catch (ApiException $e) {

            $this->logError('Error fetching articles', ['message' => $e->getMessage(), 'source_api' => $this->apiSourceId]);

            return [];
        }
    }
}
