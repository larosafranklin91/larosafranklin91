<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CnpjController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts/app');
});


Route::get('fornecedores/data', [FornecedorController::class, 'getFornecedores'])->name('fornecedores.data');
Route::resource('fornecedores', FornecedorController::class);
Route::get('/cnpj-form', [CnpjController::class, 'showForm']);
Route::post('/fetch-cnpj-data', [CnpjController::class, 'fetchCnpjData']);
Route::delete('/fornecedores/delete/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');

