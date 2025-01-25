<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Query\Builder;

interface ArticleRepositoryInterface
{
    public function all(): LengthAwarePaginator;

    public function store(array $article): Article;

    public function applyFilters(array $filters): Builder;

    public function search(array $filters): LengthAwarePaginator;

}
