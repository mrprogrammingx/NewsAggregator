<?php

namespace App\Contracts;

interface NewsAdaptersFactoryInterface
{
    public static function make(string $apiSourceId): ArticleAdapterInterface;
}
