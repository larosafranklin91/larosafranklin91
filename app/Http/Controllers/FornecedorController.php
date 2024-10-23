<?php

namespace App\Http\Controllers;

use App\Repositories\FornecedorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FornecedorController extends Controller
{
    protected $fornecedorRepository;

    public function __construct(FornecedorRepositoryInterface $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function index()
    {
        $fornecedores = Cache::remember('fornecedores', 60, function () {
            return $this->fornecedorRepository->all();
        });
    
        return response()->json($fornecedores);
    }

    public function show($documento)
    {
        $fornecedor = $this->fornecedorRepository->find($documento);
        return response()->json($fornecedor);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'documento' => 'required|unique:fornecedores|cpf_cnpj',
                'endereco' => 'string|max:255',
                'telefone' => 'required|string|max:15',
                'email' => 'required|email|unique:fornecedores'
            ]);

            $fornecedor = $this->fornecedorRepository->create($validatedData);

            // Limpa o cache
            Cache::forget('fornecedores');

            return response()->json($fornecedor, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erros de validação',
                'erros' => $th->validator->errors()
            ], 422);
        }

    }

    public function update(Request $request, $documento)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'string|max:255',
                'documento' => 'unique:fornecedores|cpf_cnpj',
                'endereco' => 'string|max:255',
                'telefone' => 'string|max:15',
                'email' => 'email|unique:fornecedores'
            ]);
    
            $fornecedor = $this->fornecedorRepository->update($documento, $validatedData);

            // Limpa o cache
            Cache::forget('fornecedores');

            return response()->json($fornecedor);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'erro',
                'mensagem' => 'Erros de validação',
                'erros' => $th->validator->errors()
            ], 422);
        }
    }

    public function destroy($documento)
    {
        $this->fornecedorRepository->delete($documento);

        // Limpa o cache
        Cache::forget('fornecedores');

        return response()->json(['status' => 'Fornecedor desativado'], 200);
    }

    public function restore($documento)
    {
        $this->fornecedorRepository->restore($documento);

        // Limpa o cache
        Cache::forget('fornecedores');

        return response()->json(['status' => 'Fornecedor ativado'], 200);
    }
}
