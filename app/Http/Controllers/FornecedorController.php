<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class FornecedorController extends Controller {

    
    public function index(Request $request){ // Listar Fornecedores
        $fornecedores = Fornecedor::query()
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                             ->orWhere('documento', 'like', "%{$search}%");
            })
            ->paginate(10);
         if ($fornecedores->isEmpty()) {
               return response()->json(['message' => 'Nenhum fornecedor encontrado.'], 404);
         }

        return response()->json($fornecedores);
    }

    public function __invoke(Request $request){
        return $this->index($request);
    }


    public function store(Request $request){ // Criar Fornecedor
    
        // Validação com mensagens personalizadas
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:CNPJ,CPF',
            'documento' => 'required|string|unique:fornecedores',
            'contato' => 'required|string',
            'endereco' => 'required|string',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'tipo.required' => 'O campo tipo é obrigatório.',
            'tipo.in' => 'O campo tipo deve ser CNPJ ou CPF.',
            'documento.required' => 'O campo documento é obrigatório.',
            'documento.unique' => 'Este documento já está cadastrado.',
            'contato.required' => 'O campo contato é obrigatório.',
            'endereco.required' => 'O campo endereco é obrigatório.',
        ]);
    
        // Limpa o documento de caracteres especiais
        $documento = preg_replace('/[^0-9a-zA-Z]/', '', $request->input('documento'));
    
        // Validar documento caso seja CNPJ
        if ($request->input('tipo') === 'CNPJ' && !$this->validarCnpj($documento)) {
            return response()->json(['message' => 'CNPJ inválido.'], 400);
        }
    
        // Validar documento caso seja CPF
        if ($request->input('tipo') === 'CPF' && !$this->validarCpf($documento)) {
            return response()->json(['message' => 'CPF inválido.'], 400);
        }
    
        $request->merge(['documento' => $documento]);
    
        // Cria o fornecedor
        $fornecedor = Fornecedor::create($request->all());
    
        return response()->json(['message' => 'Fornecedor criado com sucesso!', 'fornecedor' => $fornecedor], 201);
    }
    



    public function update(Request $request, $id){ // Editar Fornecedor
        $fornecedor = Fornecedor::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|in:CNPJ,CPF',
            'documento' => 'required|string|unique:fornecedores,documento,' . $fornecedor->id,
            'contato' => 'required|string',
            'endereco' => 'required|string',
        ]);

        $fornecedor->update($request->all());

        return response()->json(['message' => 'Fornecedor atualizado com sucesso!', 'fornecedor' => $fornecedor]);
    }

    public function destroy($id){ // Excluir Fornecedor
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return response()->json(['message' => 'Fornecedor excluído com sucesso!']);
    }


    public function buscarCnpj($cnpj){ // Buscar CNPJ na BrasilAPI com validação

        $cnpj = preg_replace('/[^0-9a-zA-Z]/', '', $cnpj); // Remover caracteres não numéricos do CNPJ
    
        if (!$this->validarCnpj($cnpj)) { // Validar CNPJ
            return response()->json(['message' => 'CNPJ inválido.'], 400);
        }

        $client = new Client();
        try {
            $response = $client->get("https://brasilapi.com.br/api/cnpj/v1/$cnpj"); // Buscar dados do CNPJ na BrasilAPI
            $data = json_decode($response->getBody()->getContents());
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar CNPJ.'], 500);
        }
    }
    
    private function validarCnpj($cnpj) { // Lógica de validação do CNPJ já usando a nova regra de cnpj alfanumérico
        
        if (strlen($cnpj) !== 14) {
            return false;
        }

        if (preg_match('/^(\w)\1+$/', $cnpj)) {         // Validar se todos os caracteres são iguais
            return false;
        }
    
        // Cálculo do dígito verificador
        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
    
        for ($i = $tamanho; $i >= 1; $i--) {
            $char = $numeros[$tamanho - $i];
            $valor = is_numeric($char) ? intval($char) : (ord($char) - 48);
            $soma += $valor * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
    
        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        if ($resultado != intval($digitos[0])) {
            return false;
        }
    
        // Cálculo do segundo dígito verificador
        $tamanho++;
        $numeros = substr($cnpj, 0, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
    
        for ($i = $tamanho; $i >= 1; $i--) {
            $char = $numeros[$tamanho - $i];
            $valor = is_numeric($char) ? intval($char) : (ord($char) - 48);
            $soma += $valor * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
    
        $resultado = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        return $resultado === intval($digitos[1]);
    }

    private function validarCpf($cpf) { // Lógica de validação do CPF
        if (strlen($cpf) !== 11) {
            return false;
        }
    
        if (preg_match('/^(\d)\1+$/', $cpf)) { // Validar se todos os caracteres são iguais
            return false;
        }
    
        // Cálculo do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += intval($cpf[$i]) * (10 - $i);
        }
    
        $resultado = $soma % 11;
        $resultado = $resultado < 2 ? 0 : 11 - $resultado;
        if ($resultado != intval($cpf[9])) {
            return false;
        }
    
        // Cálculo do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += intval($cpf[$i]) * (11 - $i);
        }
    
        $resultado = $soma % 11;
        $resultado = $resultado < 2 ? 0 : 11 - $resultado;
        return $resultado === intval($cpf[10]);
    }


}
