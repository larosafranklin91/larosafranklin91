<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;

// Redireciona a rota padrao para 'fornecedores'
Route::get('/', function () {
    return redirect()->route('fornecedores.index');
});

// Rotas para buscar CNPJ e obter fornecedores
Route::get('/buscar-cnpj', [FornecedorController::class, 'buscarCNPJ'])->name('fornecedores.buscarCNPJ');
Route::get('/fornecedores/data', [FornecedorController::class, 'getFornecedores'])->name('fornecedores.data');

// Rota resource para fornecedores
Route::resource('/fornecedores', FornecedorController::class);
