<?php

use App\Http\Controllers\CnpjController;
use App\Http\Controllers\FornecedorController;
use Illuminate\Support\Facades\Route;

Route::apiResource('fornecedores', FornecedorController::class);

// Grupo de rotas
Route::group(['prefix' => 'fornecedores'], function () {
    Route::patch('/{documento}/restore', [FornecedorController::class, 'restore'])->name('fornecedores.restore');
});

Route::get('buscar-cnpj/{cnpj}', [CnpjController::class, 'buscarCnpj']);