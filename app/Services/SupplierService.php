<?php

namespace App\Services;

use App\Exceptions\CepNotFoundException;
use App\Exceptions\CnpjNotFoundException;
use App\Repositories\SupplierRepository;
use App\Services\BrasilApiService;
use Illuminate\Support\Facades\Cache;

class SupplierService
{

    protected SupplierRepository $repository;
    protected BrasilApiService $brasilApiService;
    private array $allowedOrderFields = ['id', 'supplier_name', 'created_at', 'updated_at', 'birthdate'];
    private array $allowedSortDirections = ['asc', 'desc'];

    public function __construct(SupplierRepository $supplierRepository, BrasilApiService $brasilApiService)
    {
        $this->repository = $supplierRepository;
        $this->brasilApiService = $brasilApiService;
    }

    public function getAllSuppliers()
    {
        return $this->repository->getAllSuppliers();
    }

    public function getFilteredSuppliers(array $filters = [], string $orderBy = 'id', string $sort = 'asc', bool $getDeleted = false, int $perPage = 10, int $page = 1)
    {
        if (!in_array($orderBy, $this->allowedOrderFields)) {
            $orderBy = 'id';
        }

        if (!in_array($sort, $this->allowedSortDirections)) {
            $sort = 'asc';
        }

        $cacheKey = "suppliers_" . md5(json_encode([$filters, $orderBy, $sort, $getDeleted, $perPage, $page]));

        return Cache::remember($cacheKey, 3600, function () use ($filters, $orderBy, $sort, $getDeleted, $perPage, $page) {
            return $this->repository->getAllSuppliers($filters, $orderBy, $sort, $getDeleted, $perPage, $page);
        });
    }

    public function getSupplierById($supplierId)
    {
        $supplier =  $this->repository->getSupplierById($supplierId);
        if (!$supplier) { return; }
        $cacheKey = 'supplier_id_' . $supplierId;

        return Cache::remember($cacheKey, 3600, function () use ($supplierId) {
            return $this->repository->getSupplierById($supplierId);
        });
    }

    public function getSupplierByDocument(string $document)
    {
        $supplier = $this->repository->getSupplierByDocument($document);
        if (!$supplier) { return; }
        $cacheKey = 'supplier_id_' . $supplier->id;

        return Cache::remember($cacheKey, 3600, function () use ($supplier) {
            return $supplier;
        });
    }

    public function createSupplier(array $data)
    {
        if ($this->isLegalPerson($data['type_person'])) {
            $this->validateCnpj($data['identity_document']);
        }

        $addressData = $this->fetchAddress($data['supply_cep']);

        $data['supply_city'] = $addressData['supply_city'];
        $data['supply_state'] = $addressData['supply_state'];
        $data['supply_address'] = $addressData['supply_address'];

        // NOTE: Adicionado o flush direto do cache por que não conseguiria implementar um sistema de tags com redis no momento.
        Cache::flush();

        return $this->repository->createSupplier($data);
    }

    public function updateSupplier(array $data, $supplierId)
    {
        if (isset($data['supply_cep'])) {
            $addressData = $this->fetchAddress($data['supply_cep']);

            $data['supply_city'] = $addressData['supply_city'];
            $data['supply_state'] = $addressData['supply_state'];
            $data['supply_address'] = $addressData['supply_address'];
        }

        Cache::flush();

        return $this->repository->updateSupplier($data, $supplierId);
    }

    public function deleteSupplier($supplierId)
    {
        Cache::flush();

        return $this->repository->deleteSupplier($supplierId);
    }

    private function isLegalPerson(string $typePerson): bool
    {
        return $typePerson === 'J';
    }

    private function validateCnpj(string $identityDocument): void
    {
        $cnpjData = $this->brasilApiService->fetchCNPJData($identityDocument);

        if (empty($cnpjData)) {
            throw new CnpjNotFoundException();
        }
    }


    private function fetchAddress(string $cep)
    {

        $addressData = current($this->brasilApiService->fetchCEPData($cep));

        if (empty($addressData)) {
            throw new CepNotFoundException();
        }

        return [
            'supply_city' => $addressData['city'] ?? null,
            'supply_address' => $addressData['street'] ?? null,
            'supply_state' => $addressData['state'] ?? null,
        ];
    }
}
