<?php

namespace App\Providers;

use App\Services\ApiSourcesService;
use App\Services\ArticleService;
use App\Repositories\ArticleRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ArticleServiceInterface;
use App\Contracts\ApiSourcesServiceInterface;
use App\Contracts\ArticleRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(ApiSourcesServiceInterface::class, ApiSourcesService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
