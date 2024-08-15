<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;

class Repository implements RepositoryInterface
{
    public function __construct(protected RepositoryInterface $repository) {}

    public function setCollectionName(string $collectionName): void
    {
        $this->repository->setCollectionName($collectionName);
    }

    public function save(object $entity): array
    {
        return $this->repository->save($entity);
    }

    public function find(int $id): array
    {
        return $this->repository->find($id);
    }

    public function update(int $id, object $entity): array
    {
        return $this->repository->update($id, $entity);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function list(array $params): Paginator
    {
        return $this->repository->list($params);
    }
}