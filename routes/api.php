<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductosDivisaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::apiResource('producto', ProductoController::class);
    Route::apiResource('divisa', DivisaController::class);
    Route::get('producto/{id}/precios', [ProductosDivisaController::class, 'prices']);
    Route::post('producto/{id}/precios', [ProductosDivisaController::class, 'storePrice']);
    Route::post('products/', [ProductoController::class, 'storePrice']);
});
