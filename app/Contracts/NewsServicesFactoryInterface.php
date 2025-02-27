<?php

namespace App\Contracts;

interface NewsServicesFactoryInterface
{
    public static function make(string $apiSourceId, ApiSourcesServiceInterface $apiSourcesService): NewsServicesInterface;
}
