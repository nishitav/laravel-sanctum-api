<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/auth/logout', [AuthController::class,'logout']);
    Route::post('/auth/logout-from-all-devices', [AuthController::class,'logoutFromAllDevices']);
    Route::get('/auth/me', [AuthController::class,'me']);
});

Route::middleware(['auth:sanctum', 'ability:products:read'])
    ->get('/products', [ProductController::class, 'index']);

Route::middleware(['auth:sanctum', 'ability:products:read'])
    ->get('/products/{id}', [ProductController::class, 'show']);

Route::middleware(['auth:sanctum', 'ability:products:create'])
    ->post('/products', [ProductController::class, 'create']);

Route::middleware(['auth:sanctum', 'ability:products:update'])
    ->put('/products/{id}', [ProductController::class, 'update']);

Route::middleware(['auth:sanctum', 'ability:products:delete'])
    ->delete('/products/{id}', [ProductController::class, 'delete']);