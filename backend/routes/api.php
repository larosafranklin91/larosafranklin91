<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Route::middleware('auth:sanctum')->group(function(){
    //The routes to supplier controller gloes here
}); */

Route::apiResource('suppliers', SupplierController::class);