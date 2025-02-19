<?php

namespace App\Services\Factories;

use App\Contracts\NewsServicesInterface;
use App\Contracts\ApiSourcesServiceInterface;
use App\Contracts\NewsServicesFactoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class NewsServicesFactory implements NewsServicesFactoryInterface
{
    public static function make(string $apiSourceId, ApiSourcesServiceInterface $apiSourcesService): NewsServicesInterface
    {
        $serviceClass = $apiSourcesService->getServiceName($apiSourceId);

        if (!class_exists($serviceClass)) {
            throw new \InvalidArgumentException("Invalid API source: {$apiSourceId}");
        }

        try {
            return app()->make($serviceClass);

        } catch (BindingResolutionException $e) {
            throw new \RuntimeException("Failed to resolve service: {$serviceClass}");
        }
    }
}
