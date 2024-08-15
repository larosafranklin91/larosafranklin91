<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;

interface RepositoryInterface
{
    public function setCollectionName(string $collectionName): void;
    public function save(object $entity): array;
    public function find(int $id): array;
    public function update(int $id, object $entity): array;
    public function delete(int $id): bool;
    public function list(array $params): Paginator;
}