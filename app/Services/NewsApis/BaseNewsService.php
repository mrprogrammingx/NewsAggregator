<?php

namespace App\Services\NewsApis;

use App\Contracts\NewsServicesInterface;
use App\Exceptions\ApiException;
use App\Exceptions\AppException;
use App\Traits\ErrorLogTrait;
use Illuminate\Support\Facades\Http;

abstract class BaseNewsService implements NewsServicesInterface
{
    use ErrorLogTrait;

    protected string $apiSourceId;

    protected array $apiSourceConfig;

    public function callApi(string $path = '', array $queryParams = [], string $resultKey = ''): array
    {
        try {

            $response = Http::get($this->apiSourceConfig['base_url'].$path, $queryParams);

            if ($response->failed()) {

                $this->logError('Failed to fetch articles', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'source_api' => $this->apiSourceId,
                ]);

                throw new ApiException('Failed to fetch articles from API:'.$this->apiSourceId);
            }

            return (array) $response->json($resultKey);
        } catch (AppException $e) {

            $this->logError('Error fetching articles', ['message' => $e->getMessage(), 'source_api' => $this->apiSourceId]);

            return [];
        }
    }
}
