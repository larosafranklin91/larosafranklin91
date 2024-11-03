<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Repositories\Contracts\AddressRepositoryInterface;

class EloquentAddressRepository implements AddressRepositoryInterface
{
    protected $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id): ?Address
    {
        return $this->model->find($id);
    }

    public function create(array $data): Address
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $address = $this->find($id);
        return $address ? $address->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $address = $this->find($id);
        return $address ? $address->delete() : false;
    }
}
