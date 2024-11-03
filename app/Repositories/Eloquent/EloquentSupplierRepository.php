<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Models\User;
use App\Repositories\Contracts\SupplierRepositoryInterface;

class EloquentSupplierRepository implements SupplierRepositoryInterface
{
    protected $model;

    public function __construct(Supplier $supplier)
    {
        $this->model = $supplier;
    }

    public function all(User $user): iterable
    {
        return $this->model->where('user_id', $user->id)->get();
    }

    public function find(int $id, User $user): ?Supplier
    {
        return $this->model->where('id', $id)->where('user_id', $user->id)->first();
    }

    public function create(array $data): Supplier
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $supplier = $this->model->find($id);
        return $supplier ? $supplier->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $supplier = $this->model->find($id);
        return $supplier ? $supplier->delete() : false;
    }
}
