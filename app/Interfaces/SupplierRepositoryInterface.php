<?php
namespace App\Interfaces;

interface SupplierRepositoryInterface
{
    public function getAllSuppliers(array $filters = [], string $orderBy = 'id', string $sort = 'asc', bool $getDeleted = false);
    public function getSupplierById($supplierId);
    public function createSupplier(array $data);
    public function updateSupplier(array $data, $supplierId);
    public function deleteSupplier($supplierId);

}
?>
