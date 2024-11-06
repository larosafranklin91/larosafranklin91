<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;
Route::get('/', function () {
    return response()->json(['message' => 'Bem-vindo à API de Fornecedores!']);
});


Route::get('/teste', function () {
    return response()->json(['message' => 'Rota de teste no web.php está funcionando!']);
});


//Route::get('fornecedores', [FornecedorController::class, 'index']);
//Route::put('fornecedores/{id}', [FornecedorController::class, 'update']);
//Route::delete('fornecedores/{id}', [FornecedorController::class, 'destroy']);
//Route::get('fornecedores/buscar-cnpj/{cnpj}', [FornecedorController::class, 'buscarCnpj']);
//




?>