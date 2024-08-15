<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SupplierResource",
 *     type="object",
 *     title="Supplier Resource",
 *     description="Resource representation of a supplier",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the supplier",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of the supplier",
 *         example="Pessoa Física",
 *         enum={"Pessoa Física", "Pessoa Jurídica"}
 *     ),
 *     @OA\Property(
 *         property="company_industry",
 *         type="string",
 *         description="Industry or sector of the supplier's company",
 *         example="Technology"
 *     ),
 *     @OA\Property(
 *         property="person",
 *         type="object",
 *         description="Details of the person related to the supplier (if applicable)",
 *         ref="#/components/schemas/PersonResource",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="legalEntity",
 *         type="object",
 *         description="Details of the legal entity related to the supplier (if applicable)",
 *         ref="#/components/schemas/LegalEntityResource",
 *         nullable=true
 *     )
 * )
 */

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'company_industry' => $this->company_industry,
            'person' => $this->when($this->person_id !== null, new PersonResource($this->person)),
            'legalEntity' => $this->when($this->legal_entity_id !== null, new LegalEntityResource($this->legalEntity ?? $this->legal_entity))
        ];
    }
}
