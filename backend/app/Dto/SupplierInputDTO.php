<?php

declare(strict_types=1);

namespace App\Dto;

class SupplierInputDTO
{
    public function __construct(
        public string|null $name,
        public string|null $type,
        public string|null $cnpj,
        public string|null $cpf,
        public string|null $company_industry,
        public string|null $phone,
        public string|null $address,
        public string|null $cep,
        public string|null $number,
        public string|null $complement,
        public string|null $neighborhood,
        public string|null $city,
        public string|null $state,
        public int|null $person_id = null,
        public int|null $legal_entity_id = null
    ) {
        
    }
}