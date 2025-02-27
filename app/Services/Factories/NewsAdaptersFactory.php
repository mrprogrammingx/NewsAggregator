<?php

namespace App\Services\Factories;

use App\Contracts\ArticleAdapterInterface;
use App\Contracts\NewsAdaptersFactoryInterface;
use App\Enums\ApiSources;
use App\Exceptions\InvalidApiSourceException;
use App\Services\Adapters\NewsApiOrgAdapter;
use App\Services\Adapters\NewYorkTimesAdapter;
use App\Services\Adapters\TheGuardianAdapter;

class NewsAdaptersFactory implements NewsAdaptersFactoryInterface
{
    public static function make(string $apiSourceId): ArticleAdapterInterface
    {
        return match ($apiSourceId) {

            ApiSources::NEWSAPIORG->value => new NewsApiOrgAdapter($apiSourceId),
            ApiSources::THEGUARDIAN->value => new TheGuardianAdapter($apiSourceId),
            ApiSources::NEWYORKTIMES->value => new NewYorkTimesAdapter($apiSourceId),

            default => throw new InvalidApiSourceException("Unsupported API source: {$apiSourceId}"),
        };
    }
}
