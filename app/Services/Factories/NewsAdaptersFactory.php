<?php

namespace App\Services\Factories;

use App\Enums\ApiSources;
use App\Contracts\ArticleAdapterInterface;
use App\Services\Adapters\NewsApiOrgAdapter;
use App\Services\Adapters\TheGuardianAdapter;
use App\Contracts\NewsAdaptersFactoryInterface;
use App\Services\Adapters\NewYorkTimesAdapter;

class NewsAdaptersFactory implements NewsAdaptersFactoryInterface
{
    public static function make(string $apiSourceId): ArticleAdapterInterface
    {
        return match ($apiSourceId) {

            ApiSources::NEWSAPIORG->value => new NewsApiOrgAdapter($apiSourceId),
            ApiSources::THEGUARDIAN->value => new TheGuardianAdapter($apiSourceId),
            ApiSources::NEWYORKTIMES->value => new NewYorkTimesAdapter($apiSourceId),
            
            default => throw new \InvalidArgumentException("Unsupported API source: {$apiSourceId}"),
        };
    }
}
