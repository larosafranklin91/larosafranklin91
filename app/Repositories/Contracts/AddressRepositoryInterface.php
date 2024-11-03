<?php

namespace App\Repositories\Contracts;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function all();
    public function find(int $id): ?Address;
    public function create(array $data): Address;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
