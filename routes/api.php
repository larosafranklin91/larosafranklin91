<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;

// Rota para listar fornecedores
Route::get('fornecedores', [FornecedorController::class, 'index']);

// Rota para teste
Route::get('teste', function () {
    return response()->json(['message' => 'Rota de teste no api.php está funcionando!']);
});


Route::post('fornecedores', [FornecedorController::class, 'store']);
Route::put('fornecedores/{id}', [FornecedorController::class, 'update']);
Route::delete('fornecedores/{id}', [FornecedorController::class, 'destroy']);
Route::get('fornecedores/buscar-cnpj/{cnpj}', [FornecedorController::class, 'buscarCnpj']);


// Rotinas de Teste para as Rotas

// Rota para teste de criação de fornecedor
Route::post('fornecedores/teste-criar', function (Request $request) {
    $response = app(FornecedorController::class)->store($request);
    return response()->json(['message' => 'Teste de criação de fornecedor executado.', 'response' => $response]);
});

// Rota para teste de edição de fornecedor
Route::put('fornecedores/teste-editar/{id}', function (Request $request, $id) {
    $response = app(FornecedorController::class)->update($request, $id);
    return response()->json(['message' => 'Teste de edição de fornecedor executado.', 'response' => $response]);
});

// Rota para teste de exclusão de fornecedor
Route::delete('fornecedores/teste-excluir/{id}', function ($id) {
    $response = app(FornecedorController::class)->destroy($id);
    return response()->json(['message' => 'Teste de exclusão de fornecedor executado.', 'response' => $response]);
});

// Rota para teste de busca de CNPJ
Route::get('fornecedores/teste-buscar-cnpj/{cnpj}', function ($cnpj) {
    $response = app(FornecedorController::class)->buscarCnpj($cnpj);
    return response()->json(['message' => 'Teste de busca de CNPJ executado.', 'response' => $response]);
});


?>