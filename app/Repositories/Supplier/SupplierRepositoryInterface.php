<?php

namespace App\Repositories\Supplier;

use App\Models\Address;
use App\Models\Supplier;
use App\Models\Telephone;
use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SupplierRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @return Collection<Supplier>
     */
    public function all(): Collection;

    /**
     * @param array $params
     * @return Collection<Supplier>
     */
    public function get(array $params);

    /**
     * @param $id
     * @return Model<Supplier> | null
     */
    public function find($id);

    /**
     * @param array $attributes
     * @return Model<Supplier>
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @return Model<Supplier>
     */
    public function update($id, array $attributes);

    /**
     * @param $id
     * @return Model<Address>
     */
    public function addAddress(Supplier $supplier, array $params);

    public function removeAddress(Supplier $supplier, $addressId);

    /**
     * @param Supplier $supplier
     * @param array $params
     * @return Model<Telephone>
     */
    public function addTelephone(Supplier $supplier, array $params);

    public function removeTelephone(Supplier $supplier, $addressId);

}
