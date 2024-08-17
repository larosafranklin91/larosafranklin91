<?php

namespace App\Repositories;

interface FornecedorRepositoryInterface
{
    public function getAllFornecedores();
    public function buscarCNPJ(string $cnpj);
    public function storeFornecedor(array $data);
    public function updateFornecedor($id, array $data);
    public function deleteFornecedor($id);
    public function findFornecedorById($id);
}
