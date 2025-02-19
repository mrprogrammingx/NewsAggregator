<?php

namespace App\Contracts;

interface NewsServicesInterface
{
    public function fetchArticles(): array;

    public function callApi(string $path,array $queryParams): array;
}
