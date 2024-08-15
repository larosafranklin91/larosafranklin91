<?php

namespace App\Services;

use App\Dto\SupplierInputDTO;
use App\Dto\SupplierOutputDTO;
use App\Repositories\Repository;
use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SupplierService
{
    protected $foreignKeys = [
        'Pessoa Física' => 'person_id', 
        'Pessoa Jurídica' => 'legal_entity_id'
    ];
    
    public function __construct(
        protected Repository $repository
    ) {
    }

    public function create(SupplierInputDTO $supplier): object
    {
        $supplierPerson = $this->createSupplierPerson($supplier);
        $fk = $this->foreignKeys[$supplier->type];
        $supplier->$fk = $supplierPerson['id'];
        $this->repository->setCollectionName('Supplier');
        $supplier = $this->repository->save($supplier);
        return new SupplierOutputDTO(...$supplier);
    }

    public function find(int $id): object
    {
        $this->repository->setCollectionName('Supplier');
        try{
            $supplier = $this->repository->find($id);
            return new SupplierOutputDTO(...$supplier);
        }catch(Exception $ex){
            throw new \Exception('Supplier not found');
        } 
    }

    public function update(int $id, SupplierInputDTO $supplier){
        $this->repository->setCollectionName('Supplier');
        $persistedSupplier = $this->repository->find($id);
        $fk = $this->foreignKeys[$supplier->type] ?? $this->foreignKeys[$persistedSupplier['type']];
        $supplierPerson = $this->updateSupplierPerson($supplier->$fk ?? $persistedSupplier[$fk], $supplier);
        $this->repository->setCollectionName('Supplier');
        $supplier = $this->repository->update($id, $supplier);
        return new SupplierOutputDTO(...$supplier);
    }

    public function delete(int $id){
        try{
            $this->repository->setCollectionName('Supplier');
            $persistedSupplier = $this->repository->find($id);
            $fk = $this->foreignKeys[$persistedSupplier['type']];
            $this->deleteSupplierPerson($persistedSupplier[$fk], $persistedSupplier['type']);
            $this->repository->setCollectionName('Supplier');
            return $this->repository->delete($id);
        }catch(Exception $ex){
            throw new Exception("Supplier couldn't be deleted");
        }
    }

    public function list(array $data){
        $this->repository->setCollectionName('Supplier');
        return $this->repository->list($data);
    }

    private function createSupplierPerson(SupplierInputDTO $supplier){
        match ($supplier->type) {
            'Pessoa Física' => $this->repository->setCollectionName('Person'),
            'Pessoa Jurídica' => $this->repository->setCollectionName('LegalEntity')
        };
        $supplierPerson = $this->repository->save($supplier);
        return $supplierPerson;
    }

    private function updateSupplierPerson($id, SupplierInputDTO $supplier){
        match ($supplier->type) {
            'Pessoa Física' => $this->repository->setCollectionName('Person'),
            'Pessoa Jurídica' => $this->repository->setCollectionName('LegalEntity')
        };
        $supplierPerson = $this->repository->update($id, $supplier);
        return $supplierPerson;
    }

    private function deleteSupplierPerson($id, $type){
        match ($type) {
            'Pessoa Física' => $this->repository->setCollectionName('Person'),
            'Pessoa Jurídica' => $this->repository->setCollectionName('LegalEntity')
        };
        return $this->repository->delete($id);
    }
}