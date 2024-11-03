<?php

namespace App\Services;

use App\Http\Requests\SuplierByCnpjRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;

class SupplierService
{
    protected $supplierRepository;
    protected $addressRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getAllSuppliers(Request $request)
    {
        $user = $request->user();

        return $this->supplierRepository->all($user);
    }

    public function createSupplier(SupplierRequest $request)
    {
        $user = $request->user();

        $addressData = $request->address;
        $address = $this->addressRepository->create($addressData);

        $supplierData = $request->supplier;
        $supplierData['address_id'] = $address->id;
        $supplierData['user_id'] = $user->id;

        $supplier = $this->storeSupplier($supplierData);
        $supplier->address = $address;

        return $supplier;
    }

    public function storeSupplier(array $data)
    {
        $supplier = $this->supplierRepository->create($data);
        return $supplier;
    }

    public function updateSupplier(SupplierRequest $request, int $id)
    {
        $supplier = $this->findSupplier(
            request: $request,
            id: $id
        );

        $addressData = $request->address;
        $address = $this->addressRepository->update($supplier->address_id, $addressData);

        $supplierData = $request->supplier;
        $supplier = $this->supplierRepository->update($id, $supplierData);


        return [
            'message' => 'Supplier updated successfully',
        ];

    }

    public function deleteSupplier(Request $request, int $id)
    {
        $supplier = $this->findSupplier(
            request: $request,
            id: $id
        );

        $this->supplierRepository->delete($supplier->id);

        return [
            'message' => 'Supplier deleted successfully',
        ];
    }

    public function findSupplier(Request $request, int $id)
    {
        $user = $request->user();
        
        $supplier = $this->supplierRepository->find($id, $user);
        if (!$supplier){
            throw new Exception("Supplier not found", 404);
        }

        return $supplier;
    }

    public function fetchAndStoreByCnpj(SuplierByCnpjRequest $request)
    {
        $user = $request->user();

        $cnpj = $request->cnpj;
        $business = BrazilApiService::getBusinessByCnpj($cnpj);

        $supplierData = [
            'fantasy_name' => $business->nome_fantasia ?? 'Não informado',
            'company_name' => $business->razao_social ?? 'Não informado',
            'cnpj' => $business->cnpj ?? 'Não informado',
            'email' => $business->email ?? 'Não informado',
            'phone' => $business->ddd_telefone_1 ?? 'Não informado',
            'responsible' => $business->qsa[0]->nome_socio ?? 'Não informado',
            'user_id' => $user->id,
        ];
        $addressData = [
            'cep' => $business->cep ?? 'Não informado',
            'state' => $business->uf ?? 'Não informado',
            'city' => $business->municipio ?? 'Não informado',
            'district' => $business->bairro ?? 'Não informado',
            'address' => $business->logradouro ?? 'Não informado',
            'number' => $business->numero ?? 'Não informado',
            'complement' => $business->complemento ?? '',
        ];

        $address = $this->addressRepository->create($addressData);
        $supplierData['address_id'] = $address->id;

        $supplier = $this->storeSupplier($supplierData);
        $supplier->address = $address;

        return $supplier;
    }
}
