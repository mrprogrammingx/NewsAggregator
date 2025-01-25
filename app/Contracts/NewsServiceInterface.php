<?php

namespace App\Contracts;

interface NewsServiceInterface
{
    public function fetchArticles(): array;

    public function callApi(string $path,array $queryParams): array;
}
