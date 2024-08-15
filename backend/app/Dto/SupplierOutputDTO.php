<?php

declare(strict_types=1);

namespace App\Dto;

class SupplierOutputDTO
{
    public function __construct(
        public int $id,
        public string $type,
        public string $company_industry,
        public string|null $person_id,
        public string|null $legal_entity_id,
        public string|null $created_at,
        public string|null $updated_at,
        public array|null $legal_entity = null,
        public array|null $person = null,
        public array|null $legalEntity = null
    ) {
    }
}