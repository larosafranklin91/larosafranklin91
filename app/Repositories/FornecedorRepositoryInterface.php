<?php

namespace App\Repositories;

interface FornecedorRepositoryInterface
{
    public function all();
    public function find($documento);
    public function create(array $data);
    public function update($documento, array $data);
    public function delete($documento);
    public function restore($documento);
}