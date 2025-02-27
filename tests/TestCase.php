<?php

namespace Tests;

use App\Contracts\ApiSourcesServiceInterface;
use App\Contracts\ArticleRepositoryInterface;
use App\Repositories\ArticleRepository;
use App\Services\ApiSourcesService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(ArticleRepositoryInterface::class, resolve(ArticleRepository::class));
        $this->app->instance(ApiSourcesServiceInterface::class, resolve(ApiSourcesService::class));
    }
}
