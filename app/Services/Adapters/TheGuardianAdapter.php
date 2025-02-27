<?php

namespace App\Services\Adapters;

use App\Contracts\ArticleAdapterInterface;

class TheGuardianAdapter implements ArticleAdapterInterface
{
    private array $apiSourceConfig;

    public function __construct(public readonly string $apiSourceId)
    {
        $this->apiSourceConfig = config("global.news.$apiSourceId");
    }

    public function transform(array $article): array
    {
        return [
            'title' => $article['webTitle'] ?? 'No Title',
            'author' => $article['references']['author'] ?? 'Unknown',
            'source' => $article['source'] ?? 'Unknown',
            'api_source' => $this->apiSourceId,
            'category' => $article['sectionId'] ?? 'General',
            'content' => substr($article['fields']['bodyText'] ?? '', 0, $this->apiSourceConfig['max_content']) ?? '',
            'description' => $article['description'] ?? '',
            'url_to_image' => '',
            'language' => '',
            'url' => $article['webUrl'],
            'published_at' => $article['webPublicationDate'] ?? now(),
        ];
    }
}
