<?php

namespace App\Repositories;

use App\Models\Fornecedor;
use Illuminate\Support\Facades\Log;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    public function all($filters = [], $orderBy = 'id', $direction = 'asc')
    {
        $query = Fornecedor::where('ativo', true);

        // Filtros
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        // Ordenação
        return $query->orderBy($orderBy, $direction)->paginate(10);
    }

    public function find($documento)
    {
        return Fornecedor::where('documento', $documento)->first();
    }


    public function create(array $data)
    {
        return Fornecedor::create($data);
    }

    public function update($documento, array $data)
    {
        $fornecedor = $this->find($documento);
        $fornecedor->update($data);
        return $fornecedor;
    }

    /**
     * SoftDelete
     */
    public function delete($documento)
    {
        $fornecedor = $this->find($documento);

        if ($fornecedor) {
            $fornecedor->ativo = false;
            $fornecedor->save();

            // Aplica soft delete
            $fornecedor->delete();
        }
    }

    /**
     * Restore
     */
    public function restore($documento)
    {
        $fornecedor = Fornecedor::withTrashed()->where('documento', $documento)->first();
        // dd();
        if ($fornecedor) {
            // Restaura do soft delete
            $fornecedor->restore();

            $fornecedor->ativo = true;
            $fornecedor->save();
        }
    }
}
