<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiSourcesServiceInterface;
use App\Http\Controllers\Controller;

class ApiSourcesController extends Controller
{
    public function __construct(public readonly ApiSourcesServiceInterface $apiSourcesService)
    {
    }
    public function allIds()
    {
        return $this->apiSourcesService->allIds();
    }
    
    public function getActiveIds()
    {
        return $this->apiSourcesService->getActiveIds();
    }
}
