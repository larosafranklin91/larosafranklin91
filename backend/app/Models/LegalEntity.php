<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @OA\Schema(
 *     schema="LegalEntity",
 *     type="object",
 *     title="LegalEntity",
 *     description="Represents a legal entity in the system.",
 *     required={"name", "cnpj", "phone", "address", "cep", "number", "neighborhood", "city", "state"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the legal entity.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the legal entity.",
 *         example="Tech Corp"
 *     ),
 *     @OA\Property(
 *         property="cnpj",
 *         type="string",
 *         description="CNPJ number of the legal entity.",
 *         example="12345678000195"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the legal entity.",
 *         example="1234567890"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the legal entity.",
 *         example="456 Business Rd"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="Postal code (CEP) of the legal entity's address.",
 *         example="12345678"
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         description="Number of the legal entity's address.",
 *         example="45A"
 *     ),
 *     @OA\Property(
 *         property="complement",
 *         type="string",
 *         description="Additional address information.",
 *         example="Suite 200"
 *     ),
 *     @OA\Property(
 *         property="neighborhood",
 *         type="string",
 *         description="Neighborhood where the legal entity is located.",
 *         example="Business District"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City where the legal entity is located.",
 *         example="San Francisco"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State where the legal entity is located.",
 *         example="CA"
 *     ),
 *     @OA\Property(
 *         property="supplier",
 *         ref="#/components/schemas/Supplier"
 *     )
 * )
 */

class LegalEntity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'phone',
        'address',
        'cep',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class);
    }
}
