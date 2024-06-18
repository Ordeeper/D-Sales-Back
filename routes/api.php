<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show'])->where('id', '[0-9]+');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->where('id', '[0-9]+');
Route::post('products', [ProductController::class, 'store']);
Route::patch('products/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+');
