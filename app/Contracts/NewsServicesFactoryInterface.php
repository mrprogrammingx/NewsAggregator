<?php

namespace App\Contracts;

use App\Contracts\ApiSourcesServiceInterface;

interface NewsServicesFactoryInterface
{
    public static function make(string $apiSourceId, ApiSourcesServiceInterface $apiSourcesService): NewsServicesInterface;
}
