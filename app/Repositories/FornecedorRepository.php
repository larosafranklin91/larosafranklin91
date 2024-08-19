<?php

namespace App\Repositories;

use App\Models\Fornecedor;
use App\Models\Endereco;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    public function getAllFornecedores()
    {
        return Fornecedor::with(['endereco', 'contatos'])->where('ativo', true)->select('fornecedores.*');
    }

    public function getFornecedoresList(array $params): LengthAwarePaginator
    {
        $query = Fornecedor::with(['endereco', 'contatos'])
            ->where('ativo', true);

        if (!empty($params['filter_value']) && !empty($params['filter_by'])) {
            $query->where(function ($q) use ($params) {
                $filterValue = $params['filter_value'];
                $filterBy = $params['filter_by'];

                $q->where($filterBy, 'like', '%' . $filterValue . '%')
                  ->orWhereHas('endereco', function ($q) use ($filterValue, $filterBy) {
                      $q->where($filterBy, 'like', '%' . $filterValue . '%');
                  });
            });
        }

        if (!empty($params['order_by']) && !empty($params['direction'])) {
            $query->orderBy($params['order_by'], $params['direction']);
        } else {
            $query->orderBy('nome', 'asc'); // Ordenação padrão
        }

        return $query->paginate(15)->appends(request()->query());
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
