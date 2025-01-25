<?php

namespace App\Contracts;

interface ArticleAdapterInterface
{
    public function __construct(string $apiSourceId);
    public function transform(array $article): array;
}
