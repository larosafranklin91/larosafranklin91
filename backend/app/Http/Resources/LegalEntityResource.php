<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="LegalEntityResource",
 *     type="object",
 *     title="Legal Entity Resource",
 *     description="Resource representation of a legal entity (empresa ou organização)",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the legal entity",
 *         example="Empresa Exemplo Ltda"
 *     ),
 *     @OA\Property(
 *         property="cnpj",
 *         type="string",
 *         description="CNPJ number of the legal entity",
 *         example="12345678000195"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the legal entity",
 *         example="11987654321"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the legal entity",
 *         example="Avenida Exemplo"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="Postal code of the legal entity's address",
 *         example="12345678"
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         description="Building number of the legal entity's address",
 *         example="1000"
 *     ),
 *     @OA\Property(
 *         property="complement",
 *         type="string",
 *         description="Address complement, such as suite or floor number",
 *         example="Sala 101"
 *     ),
 *     @OA\Property(
 *         property="neighborhood",
 *         type="string",
 *         description="Neighborhood of the legal entity's address",
 *         example="Centro"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City of the legal entity's address",
 *         example="São Paulo"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State of the legal entity's address",
 *         example="SP",
 *         enum={
 *             "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", 
 *             "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", 
 *             "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"
 *         }
 *     )
 * )
 */

class LegalEntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this['name'],
            'cnpj' => $this['cnpj'],
            'phone' => $this['phone'],
            'address' => $this['address'],
            'cep' => $this['cep'],
            'number' => $this['number'],
            'complement' => $this['complement'],
            'neighborhood' => $this['neighborhood'],
            'city' => $this['city'],
            'state' => $this['state'],
        ];
    }
}
