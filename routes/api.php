<?php

use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::middleware('auth:api')->group(function () {
    
    Route::apiResource('suppliers', SupplierController::class)->names('suppliers');

    Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
});



