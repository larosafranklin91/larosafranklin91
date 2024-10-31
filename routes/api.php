<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::apiResource('suppliers', SupplierController::class);
    Route::get('/suppliers/document/{document}', [SupplierController::class, 'showByDocument']);
});
