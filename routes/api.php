<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;

Route::post('/login', [AuthController::class, 'getToken']);

Route::get('/product/{id}', [ProductApiController::class, 'show']);
Route::get('/product', [ProductApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/product', [ProductApiController::class, 'store']);
    Route::put('/product/{id}', [ProductApiController::class, 'update']);
    Route::delete('/product/{id}', [ProductApiController::class, 'destroy']);
    
    // Category (Semua method dengan otentikasi berdasarkan Tugas 1)
    Route::get('/category', [CategoryApiController::class, 'index']);
    Route::get('/category/{id}', [CategoryApiController::class, 'show']);
    Route::post('/category', [CategoryApiController::class, 'store']);
    Route::put('/category/{id}', [CategoryApiController::class, 'update']);
    Route::delete('/category/{id}', [CategoryApiController::class, 'destroy']);
});
