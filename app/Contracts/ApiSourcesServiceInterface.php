<?php

namespace App\Contracts;

interface ApiSourcesServiceInterface
{
    public function allIds(): array;

    public function getActiveIds(): array;

    public function getServiceName(string $apiSourceId): string;
}
