<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;

/**
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1, description="Identificador único do fornecedor"),
 *     @OA\Property(property="supplier_name", type="string", maxLength=255, example="Fornecedor XYZ", description="Nome do fornecedor"),
 *     @OA\Property(property="identity_document", type="string", minLength=11, maxLength=14, example="12345678900", description="Número do documento (CPF ou CNPJ) do fornecedor"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="fornecedor@example.com", description="E-mail do fornecedor"),
 *     @OA\Property(property="supply_cep", type="string", minLength=8, maxLength=8, example="82520120", description="CEP do local de faturamento do fornecedor"),
 *     @OA\Property(property="supply_city", type="string", maxLength=255, example="Curitiba", description="Cidade do Fornecedor"),
 *     @OA\Property(property="supply_state", type="string", maxLength=255, example="Paraná", description="Estado do Fornecedor"),
 *     @OA\Property(property="supply_address", type="string", maxLength=255, example="R. José de Alencar", description="Rua do Fornecedor"),
 *     @OA\Property(property="supply_address_complement", type="string", maxLength=20, example="123-A", description="Número e complemento do local do fornecedor"),
 *     @OA\Property(property="phone", type="string", minLength=10, maxLength=11, example="41984653641", description="Telefone ou celular do fornecedor"),
 *     @OA\Property(property="birthdate", type="date", example="2002-08-20", description="Data de nascimento do fornecedor (caso seja CPF)"),
 *     @OA\Property(property="type_person", type="enum('F, J')", example="F", description="Tipo de Pessoa (Física ou Júridica)"),
 *     @OA\Property(property="created_at", type="datetime", example="2024-10-30T19:48:04.000000Z", description="Data e hora de criação do fornecedor"),
 *     @OA\Property(property="update_at", type="datetime", example="2024-10-30T19:48:04.000000Z", description="Data e hora de atualização do fornecedor"),
 *     @OA\Property(property="deleted_at", type="datetime", example="2024-10-30T19:48:04.000000Z", description="Data e hora de remoção do fornecedor"),
 * )
 */
class SupplierRepository implements SupplierRepositoryInterface
{

    public function getAllSuppliers(array $filters = [], string $orderBy = 'id', string $sort = 'asc', bool $getDeleted = false, int $perPage = 10, int $page = 1)
    {
        $query = $getDeleted ? Supplier::withTrashed() : Supplier::query();

        $this->applyFilters($query, $filters);
        $this->applyOrdering($query, $orderBy, $sort);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getSupplierById($supplierId)
    {
        return Supplier::find($supplierId);
    }

    public function getSupplierByDocument(string $document)
    {
        return Supplier::where('identity_document', $document)->first();
    }

    public function createSupplier(array $data)
    {
        return Supplier::create($data);
    }

    public function updateSupplier(array $data, $supplierId)
    {
        Supplier::whereId($supplierId)->update($data);
        return Supplier::whereId($supplierId)->get();
    }

    public function deleteSupplier($supplierId)
    {
        return Supplier::destroy($supplierId);
    }

    private function applyFilters($query, array $filters): void
    {
        foreach ($filters as $field => $value) {
            $query->where($field, 'like', '%' . $value . '%');
        }
    }

    private function applyOrdering($query, string $orderBy, string $sort): void
    {
        $query->orderBy($orderBy, $sort);
    }
}
