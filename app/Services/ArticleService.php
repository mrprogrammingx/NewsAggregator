<?php

namespace App\Services;

use App\Models\Article;
use App\Enums\ApiSources;
use Illuminate\Support\Facades\Log;
use App\Contracts\ArticleServiceInterface;
use App\Contracts\ArticleRepositoryInterface;
use App\Services\Factories\NewsAdapterFactory;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceInterface
{
    public function __construct(public readonly ArticleRepositoryInterface $articleRepository)
    {
    }
    public function all(): LengthAwarePaginator
    {
        return $this->articleRepository->all();
    }

    public function store(array $article): Article
    {
        return $this->articleRepository->store($article);
    }

    public function fetchAllNewsApies(): array
    {
        $transformArticles = [];
        foreach ([$this->getActiveApiSourceIds()[0]] as $apiSourceId) {

            Log::info('Start fetching:', [now(), $apiSourceId]);

            $transformArticles = array_merge($transformArticles, $this->fetchNewsApi($apiSourceId));
        }

        return $transformArticles;
    }

    public function getActiveApiSourceIds(): array
    {
        return array_keys(
            array_filter(
                config('global.news'),
                fn($item) => $item['active'] === true
            )
        );
    }

    public function fetchNewsApi(string $apiSourceId): array
    {
        $ApiSourceService = $this->getApiSourceServiceName($apiSourceId);

        $articlesResponse = [
            ['webUrl' => $apiSourceId, 'web_url' => $apiSourceId, 'url' => $apiSourceId],
            ['webUrl' => $apiSourceId, 'web_url' => $apiSourceId, 'url' => $apiSourceId],
        ];
        // $articlesResponse = new $ApiSourceService()->fetchArticles(); // fetch Api Source response for every api source
        //TODO 
        return $this->convertApiResponseToDatabaseColumns($apiSourceId, $articlesResponse);
    }

    public function getApiSourceServiceName(string $apiSourceId): string
    {
        return 'App\Services\NewsApis\\' . ApiSources::serviceClassName($apiSourceId); //call service class based on each api source
    }

    public function convertApiResponseToDatabaseColumns(string $apiSourceId, ?array $articlesResponse): array
    {
        $adapter = NewsAdapterFactory::make($apiSourceId);

        $transformArticles = [];
        foreach ($articlesResponse as $article) {
            $transformArticles[] = $adapter->transform($article);
        }

        return $transformArticles;
    }

    public function search(array $filters): LengthAwarePaginator
    {
        $filters = $this->extractFilters($filters);

        $articles = $this->articleRepository->search($filters);

        return $articles;
    }

    public function extractFilters(array $filters): array
    {
        return [
            'search' => $filters['search'] ?? null,
            'category' => $filters['category'] ?? null,
            'source' => $filters['source'] ?? null,
            'api_source' => $filters['api_source'] ?? null,
            'author' => $filters['author'] ?? null,
            'date_from' => $filters['date_from'] ?? null,
            'date_to' => $filters['date_to'] ?? null,
            'per_page' => $filters['per_page'] ?? 10,//TODO
        ];
    }

    //TODO // method fetch and save in datebase 
}
