<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ApiSourcesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ArticleController::class)->prefix('/articles')->group(function(){
    Route::get('', 'index');
    Route::get('/fetch', 'fetchAllNewsApies');
    Route::post('', 'store');
    Route::get('/filter', 'search');
    Route::post('/fetch/store', 'saveAllFetchedNewsApies');
});

Route::controller(ApiSourcesController::class)->prefix('/api-sources')->group( function() {
    Route::get('/ids', 'allIds');
    Route::get('/activeIds', 'getActiveIds');    
});