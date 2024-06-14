<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show'])->where('id', '[0-9]+');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->where('id', '[0-9]+');
    Route::post('products', [ProductController::class, 'store']);
});
