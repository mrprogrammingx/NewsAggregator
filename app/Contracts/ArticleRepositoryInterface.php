<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function all(): LengthAwarePaginator;

    public function store(array $article): Article;

    public function applyFilters(array $filters): Builder;

    public function search(array $filters): LengthAwarePaginator;
}
