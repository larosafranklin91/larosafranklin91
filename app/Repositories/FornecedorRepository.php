<?php

namespace App\Repositories;

use App\Models\Fornecedor;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    public function getAllFornecedores()
    {
        return Fornecedor::with(['endereco', 'contatos'])->where('ativo', true)->select('fornecedores.*');
    }

    public function buscarCNPJ(string $cnpj)
    {
        return Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");
    }

    public function storeFornecedor(array $data)
    {
        DB::beginTransaction();

        try {
            $fornecedor = $this->createOrUpdateFornecedor(new Fornecedor, $data);
            DB::commit();
            return $fornecedor;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateFornecedor($id, array $data)
    {
        DB::beginTransaction();

        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $this->createOrUpdateFornecedor($fornecedor, $data);
            DB::commit();
            return $fornecedor;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteFornecedor($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->ativo = false;
        $fornecedor->save();
        return $fornecedor;
    }

    public function findFornecedorById($id)
    {
        return Fornecedor::with('endereco', 'contatos')->findOrFail($id);
    }

    private function createOrUpdateFornecedor(Fornecedor $fornecedor, array $data)
    {
        $endereco = Endereco::updateOrCreate(
            ['id' => $fornecedor->endereco_id],
            [
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'complemento' => $data['complemento'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'uf' => $data['uf'],
                'cep' => $data['cep'],
            ]
        );

        $fornecedor->fill([
            'nome' => $data['nome'],
            'cpf' => $data['cpf'],
            'cnpj' => $data['cnpj'],
            'endereco_id' => $endereco->id,
        ]);
        $fornecedor->save();

        $fornecedor->contatos()->delete();
        foreach ($data['telefone'] as $index => $telefone) {
            if (!empty($telefone)) {
                $fornecedor->contatos()->create([
                    'telefone' => $telefone,
                    'email' => $data['email'][$index] ?? null,
                ]);
            }
        }

        return $fornecedor;
    }
}
