<?php

namespace App\Services\Adapters;

use App\Contracts\ArticleAdapterInterface;

class NewsApiOrgAdapter implements ArticleAdapterInterface
{
    public function __construct(public readonly string $apiSourceId)
    {
    }

    public function transform(array $article): array
    {
        return [
            'title' => $article['title'] ?? 'No Title',
            'author' => $article['author'] ?? 'Unknown',
            'source' => $article['source']['name'] ?? 'Unknown',
            'api_source' => $this->apiSourceId,
            'category' => $article['category'] ?? 'General', 
            'content' => $article['content'] ?? '',
            'description' => $article['description'] ?? '',
            'url_to_image' => $article['urlToImage'] ?? '',
            'language' => '',
            'url' => $article['url'],
            'published_at' => $article['publishedAt'] ?? now(),
        ];
    }
}
