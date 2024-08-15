<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PersonResource",
 *     type="object",
 *     title="Person Resource",
 *     description="Resource representation of a person",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the person",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF number of the person",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the person",
 *         example="11987654321"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the person",
 *         example="Rua Exemplo"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="Postal code of the person's address",
 *         example="12345678"
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         description="House or building number of the person's address",
 *         example="123"
 *     ),
 *     @OA\Property(
 *         property="complement",
 *         type="string",
 *         description="Address complement, such as apartment number",
 *         example="Apto 101"
 *     ),
 *     @OA\Property(
 *         property="neighborhood",
 *         type="string",
 *         description="Neighborhood of the person's address",
 *         example="Centro"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City of the person's address",
 *         example="São Paulo"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State of the person's address",
 *         example="SP",
 *         enum={
 *             "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", 
 *             "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", 
 *             "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"
 *         }
 *     )
 * )
 */

class PersonResource extends JsonResource
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
            'cpf' => $this['cpf'],
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
