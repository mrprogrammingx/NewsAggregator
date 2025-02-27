<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceInterface
{
    public function all(): LengthAwarePaginator;

    public function store(array $article): ?Article;

    public function fetchAllNewsApies(): array;

    public function fetchNewsApi(string $apiSourceId): array;

    public function convertApiResponseToDatabaseColumns(string $apiSourceId, ?array $articlesResponse): array;

    public function search(array $filters): LengthAwarePaginator;

    public function extractFilters(array $filters): array;

    public function storeArticles(array $articles): array;

    public function saveAllFetchedNewsApies(): array;
}
