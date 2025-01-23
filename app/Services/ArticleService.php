<?php

namespace App\Services;

use App\Models\Article;
use App\Contracts\ArticleServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ArticleService implements ArticleServiceInterface
{
    public function all(): Collection{
        return Article::all();
    }
}
