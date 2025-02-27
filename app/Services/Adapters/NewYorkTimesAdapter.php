<?php

namespace App\Services\Adapters;

use App\Contracts\ArticleAdapterInterface;

class NewYorkTimesAdapter implements ArticleAdapterInterface
{
    public function __construct(public readonly string $apiSourceId) {}

    public function transform(array $article): array
    {
        return [
            'title' => $article['headline']['main'] ?? $article['abstract'] ?? 'No Title',
            'author' => $article['byline']['original'] ?? 'Unknown',
            'source' => $article['source'] ?? 'Unknown',
            'api_source' => $this->apiSourceId,
            'category' => $article['section_name'] ?? 'General',
            'content' => $article['lead_paragraph'] ?? '',
            'description' => $article['snippet'] ?? '',
            'url_to_image' => $article['multimedia'][0]['url'] ?? '',
            'language' => $article['language'] ?? '',
            'url' => $article['web_url'],
            'published_at' => $article['pub_date'] ?? now(),
        ];
    }
}
