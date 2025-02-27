<?php

namespace Tests\Unit;

use App\Services\ArticleService;
use Mockery;
use Tests\TestCase;

class FetchNewsDataTest extends TestCase
{
    public function test_fetch_news_data_command_warns_no_news_data()
    {
        $articleServiceMock = Mockery::mock(ArticleService::class);

        $articleServiceMock->shouldReceive('saveAllFetchedNewsApies')
            ->once()
            ->andReturn([]); // Simulate empty array response

        $this->app->instance(ArticleService::class, $articleServiceMock);

        $this->artisan('app:fetch-news-data')
            ->expectsOutput('There is not news data.')
            ->assertExitCode(0);
    }

    public function test_fetch_news_data_command_executes_successfully()
    {
        $articleServiceMock = Mockery::mock(ArticleService::class);

        $articleServiceMock->shouldReceive('saveAllFetchedNewsApies')
            ->once()
            ->andReturn(['article1', 'article2']); // Simulate non-empty array response

        $this->app->instance(ArticleService::class, $articleServiceMock);

        $this->artisan('app:fetch-news-data')
            ->expectsOutput('News data fetched and stored successfully.')
            ->assertExitCode(0);
    }
}
