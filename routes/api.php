<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('supplier')->group(function () {
        Route::GET('/', [\App\Http\Controllers\SupplierController::class, 'index']);
        Route::GET('/{id}', [\App\Http\Controllers\SupplierController::class, 'show']);
        Route::POST('/', [\App\Http\Controllers\SupplierController::class, 'store']);
        Route::POST('/by-cnpj', [\App\Http\Controllers\SupplierController::class, 'fetchAndStoreByCnpj']);
        Route::PUT('/{id}', [\App\Http\Controllers\SupplierController::class, 'update']);
        Route::DELETE('/{id}', [\App\Http\Controllers\SupplierController::class, 'destroy']);
    });


});
