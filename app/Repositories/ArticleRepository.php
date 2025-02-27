<?php

namespace App\Repositories;

use App\Contracts\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function __construct(public Article $article) {}

    public function all(): LengthAwarePaginator
    {
        return $this->article::paginate(10);
    }

    public function store(array $article): Article
    {
        return $this->article::updateOrCreate(
            ['url' => $article['url']],
            $article
        );
    }

    public function applyFilters(array $filters): Builder
    {
        $query = $this->article::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('content', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (! empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (! empty($filters['api_source'])) {
            $query->where('api_source', $filters['api_source']);
        }

        if (! empty($filters['author'])) {
            $query->where('author', $filters['author']);
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('published_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('published_at', '<=', $filters['date_to']);
        }

        return $query;
    }

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->applyFilters($filters)->paginate($filters['per_page']);
    }
}
