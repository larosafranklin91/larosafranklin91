<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('suppliers', \App\Http\Controllers\SupplierController::class);
Route::apiResource('suppliers.addresses', \App\Http\Controllers\SupplierAddressController::class);
Route::apiResource('suppliers.telephones', \App\Http\Controllers\SupplierTelephoneController::class);
Route::get('search-company/{document}', \App\Http\Controllers\SearchCompanyController::class);
