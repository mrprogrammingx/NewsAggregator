<?php

namespace App\Services\Factories;

use App\Contracts\ApiSourcesServiceInterface;
use App\Contracts\NewsServicesFactoryInterface;
use App\Contracts\NewsServicesInterface;
use App\Exceptions\BindingException;
use App\Exceptions\InvalidApiSourceException;
use App\Exceptions\RuntimeAppException;

class NewsServicesFactory implements NewsServicesFactoryInterface
{
    public static function make(string $apiSourceId, ApiSourcesServiceInterface $apiSourcesService): NewsServicesInterface
    {
        $serviceClass = $apiSourcesService->getServiceName($apiSourceId);

        if (! class_exists($serviceClass)) {
            throw new InvalidApiSourceException("Invalid API source: {$apiSourceId}");
        }

        try {
            return app()->make($serviceClass);

        } catch (BindingException $e) {
            throw new RuntimeAppException("Failed to resolve service: {$serviceClass}");
        }
    }
}
