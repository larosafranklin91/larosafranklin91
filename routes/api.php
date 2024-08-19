<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;

Route::get('/fornecedores', [FornecedorController::class, 'getFornecedoresList'])->name('fornecedores.get');
