<?php

namespace App\Services;

use App\Models\Article;
use App\Traits\ErrorLogTrait;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\Log;
use App\Contracts\ArticleServiceInterface;
use App\Http\Requests\ArticleStoreRequest;
use App\Contracts\ApiSourcesServiceInterface;
use App\Contracts\ArticleRepositoryInterface;
use App\Services\Factories\NewsAdapterFactory;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceInterface
{
    use ValidationTrait;
    use ErrorLogTrait;

    private array $articleConfig;

    public function __construct(
        public ArticleRepositoryInterface $articleRepository,
        public ApiSourcesServiceInterface $apiSourcesService,
        )
    {
        $this->articleConfig = config('global.articles');
    }
    public function all(): LengthAwarePaginator
    {
        return $this->articleRepository->all();
    }

    public function store(array $article): ?Article
    {
        $validatedArticle = $this->validateWithCustomFormRequest($article, new ArticleStoreRequest());

        if($validatedArticle === false){
            $this->logError('Failed to saving Article in the database:', $article);
            return null;
        }

        return $this->articleRepository->store($validatedArticle);
    }

    public function fetchAllNewsApies(): array
    {
        $allTransformedArticles = [];
        foreach ($this->apiSourcesService->getActiveIds() as $apiSourceId) {

            Log::info('Start fetching:', [now(), $apiSourceId]);

            $transformedArticles = $this->fetchNewsApi($apiSourceId);

            $allTransformedArticles = array_merge($allTransformedArticles, $transformedArticles);
        }

        return $allTransformedArticles;
    }

    public function fetchNewsApi(string $apiSourceId): array
    {
        $ApiSourceServiceClass = $this->apiSourcesService->getServiceName($apiSourceId);

        $articlesResponse = new $ApiSourceServiceClass()->fetchArticles(); // fetch Api Source response for every api source based on api source id for example: NewsApiOrgService()

        return $this->convertApiResponseToDatabaseColumns($apiSourceId, $articlesResponse);
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
        return $this->articleRepository->search(
            $this->extractFilters($filters)
        );
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
            'per_page' => $filters['per_page'] ?? $this->articleConfig['pagination']['default_per_page'],
        ];
    }

    public function storeArticles(array $articles): array
    {
        Log::info('Start saving articles to the database.');
        
        $savedArticles = [];
        foreach($articles as $article)
        {
            $result = $this->store($article);

            if($result === null){
                $this->logError('Error saving article to database.', $article);
            }
            $savedArticles[] = $result; 

        }

        Log::info('Finished saving articles to the database.', ['count' => count($savedArticles)]);

        return $savedArticles;
    }

    public function SaveAllFetchedNewsApies(): array
    {
        return $this->storeArticles(articles: $this->fetchAllNewsApies());
    }
}
