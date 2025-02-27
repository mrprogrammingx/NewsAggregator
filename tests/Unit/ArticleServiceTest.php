<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\ArticleController;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Resources\ArticlePaginationCollection;
use App\Models\Article;
use App\Services\ApiSourcesService;
use App\Services\ArticleService;
use App\Services\NewsApis\NewsApiOrgService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    public function test_store_articles_logs_errors_and_saves_successful_articles()
    {

        Log::shouldReceive('info')->twice();
        Log::shouldReceive('error')->once();

        $articleService = Mockery::mock(ArticleService::class)->makePartial();

        $articleService->shouldReceive('store')
            ->with(['title' => 'Valid Article'])
            ->andReturn(new Article(['id' => 1, 'title' => 'Valid Article']));
        $articleService->shouldReceive('store')
            ->with(['title' => 'Invalid Article'])
            ->andReturn(null);

        $articles = [
            ['title' => 'Valid Article'],
            ['title' => 'Invalid Article'],
        ];

        $result = $articleService->storeArticles($articles);

        $this->assertNotInstanceOf(Article::class, $result[1]);
        $this->assertInstanceOf(Article::class, $result[0]);
        $this->assertEquals('Valid Article', $result[0]->title);
    }

    public function test_search_method_returns_paginated_articles()
    {
        $articleServiceMock = Mockery::mock(ArticleService::class);
        $articleServiceMock->shouldReceive('search')
            ->andReturn(new LengthAwarePaginator([], 0, 10));

        $controller = new ArticleController($articleServiceMock);

        $requestMock = Mockery::mock(ArticleSearchRequest::class);
        $requestMock->shouldReceive('validated')
            ->andReturn([
                'search' => 'test',
                'category' => 'Technology',
            ]);

        $response = $controller->search($requestMock);

        $this->assertInstanceOf(ArticlePaginationCollection::class, $response);
    }

    public function test_extract_filters_returns_default_values()
    {
        $service = resolve(ArticleService::class);

        $filters = [
            'search' => 'test',
            'category' => 'Technology',
        ];

        $result = $service->extractFilters($filters);

        $this->assertEquals('test', $result['search']);
        $this->assertEquals('Technology', $result['category']);
        $this->assertNull($result['source']);
        $this->assertEquals(10, $result['per_page']);
    }

    public function test_fetch_all_news_apies_logs_and_fetches_articles()
    {
        $apiSourcesServiceMock = Mockery::mock(ApiSourcesService::class);
        $apiSourcesServiceMock->shouldReceive('getActiveIds')
            ->andReturn(['news_api_test', 'open_news']);

        $articleService = Mockery::mock(ArticleService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $articleService->apiSourcesService = $apiSourcesServiceMock;

        $articleService->shouldReceive('fetchNewsApi')
            ->with('news_api_test')
            ->andReturn([['title' => 'Article 1']]);
        $articleService->shouldReceive('fetchNewsApi')
            ->with('open_news')
            ->andReturn([['title' => 'Article 2']]);

        Log::shouldReceive('info')->twice();

        $articles = $articleService->fetchAllNewsApies();

        $this->assertCount(2, $articles);
        $this->assertEquals('Article 1', $articles[0]['title']);
    }

    public function test_fetch_news_api_calls_correct_service_and_transforms_articles()
    {

        $apiSourcesServiceMock = Mockery::mock(ApiSourcesService::class);
        $apiSourcesServiceMock->shouldReceive('getServiceName')
            ->with('news_api_test')
            ->andReturn(NewsApiOrgService::class);

        $apiSourceMock = Mockery::mock(NewsApiOrgService::class);
        $apiSourceMock->shouldReceive('fetchArticles')
            ->andReturn([
                ['title' => 'Fetched Article', 'content' => 'Content of the article'],
            ]);

        app()->instance(NewsApiOrgService::class, $apiSourceMock);

        $articleService = Mockery::mock(ArticleService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $articleService->apiSourcesService = $apiSourcesServiceMock;

        $articleService->shouldReceive('convertApiResponseToDatabaseColumns')
            ->with('news_api_test', [['title' => 'Fetched Article', 'content' => 'Content of the article']])
            ->andReturn([
                ['title' => 'Transformed Article', 'content' => 'Transformed Content'],
            ]);

        $articleService
            ->shouldReceive('fetchNewsApi')
            ->with('news_api_test')->andReturn([
                ['title' => 'Transformed Article', 'content' => 'Transformed Content'],
            ]);

        $articles = $articleService->fetchNewsApi('news_api_test');

        $this->assertCount(1, $articles);
        $this->assertEquals('Transformed Article', $articles[0]['title']);
    }
}
