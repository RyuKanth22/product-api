<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::apiResource('products', ProductoController::class);
    Route::apiResource('divisa', DivisaController::class);
    Route::get('products/{id}/prices', [ProductoController::class, 'prices']);
    Route::post('products/{id}/prices', [ProductoController::class, 'storePrice']);
    Route::post('products/', [ProductoController::class, 'storePrice']);
    Route::post('/login', [AuthController::class, 'login']);
});
