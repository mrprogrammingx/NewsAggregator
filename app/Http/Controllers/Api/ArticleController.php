<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Contracts\ArticleServiceInterface;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Resources\ArticlePaginationCollection;

class ArticleController extends Controller
{
    public function __construct(public readonly ArticleServiceInterface $articleService)
    {
    }
    
    public function index(): ArticlePaginationCollection
    {
        return new ArticlePaginationCollection($this->articleService->all());
    }

    public function store(ArticleStoreRequest $request): ArticleResource
    {
        return new ArticleResource($this->articleService->store($request->validated()));
    }

    public function fetchAllNewsApies(): array
    {
        $articles = $this->articleService->fetchAllNewsApies();
        return $articles;
    }

    public function search(ArticleSearchRequest $request): ArticlePaginationCollection
    {
        return new ArticlePaginationCollection($this->articleService->search($request->validated()));
    }

    public function saveAllFetchedNewsApies(): array
    {
        return $this->articleService->saveAllFetchedNewsApies();
    }
}
