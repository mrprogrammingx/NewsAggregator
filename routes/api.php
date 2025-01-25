<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/fetch', [ArticleController::class, 'fetchAllNewsApies']);
Route::post('/articles/store', [ArticleController::class, 'store']);
Route::get('/articles/search', [ArticleController::class, 'search']);

