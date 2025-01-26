<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('news',['articles' => resolve(ArticleController::class)->index()]);
});