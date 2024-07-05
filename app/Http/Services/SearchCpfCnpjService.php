<?php

namespace App\Http\Services;

use App\Models\Supplier;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;


class SearchCpfCnpjService
{
    public function findCpfCnpj(string $cpfCnpj): array
    {

        $result = Http::get("http://www.receitaws.com.br/v1/cnpj/{$cpfCnpj}");
        
        return $result->json();
    }


   public function setCnpj(Supplier $supplier): Supplier
    {
        $cpfCnpj = $supplier->cpf_cnpj;
        $response = $this->findCpfCnpj($cpfCnpj);
        
        $supplier->company_name = $response['nome'];
        $supplier->address = $response['logradouro'];
        $supplier->city = $response['municipio'];
        $supplier->state = $response['uf'];
        $supplier->zip = $response['cep'];
        $supplier->phone = $response['telefone'];

        return $supplier;
    }

    public function validateCpfCnpj(string $cpfCnpj): bool
    {
        $response = $this->findCpfCnpj($cpfCnpj);

        if(isset($response['status']) && $response['status'] === 'ERROR') {
            return false;
        }

        return true;
    }



}