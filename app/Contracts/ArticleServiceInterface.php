<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ArticleServiceInterface
{
    public function all(): Collection;
}
