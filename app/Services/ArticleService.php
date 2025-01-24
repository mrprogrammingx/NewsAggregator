<?php

namespace App\Services;

use App\Contracts\ArticleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    public function __construct(public readonly ArticleRepositoryInterface $articleRepository)
    {

    }
    public function all(): Collection{
        return $this->articleRepository->all();
    }
}
