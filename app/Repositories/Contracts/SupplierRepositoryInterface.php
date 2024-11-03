<?php

namespace App\Repositories\Contracts;

use App\Models\Supplier;
use App\Models\User;

interface SupplierRepositoryInterface
{
    public function all(User $user);
    public function find(int $id, User $user): ?Supplier;
    public function create(array $data): Supplier;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
