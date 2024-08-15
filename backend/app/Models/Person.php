<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @OA\Schema(
 *     schema="Person",
 *     type="object",
 *     title="Person",
 *     description="Represents a person entity in the system.",
 *     required={"name", "cpf", "phone", "address", "cep", "number", "neighborhood", "city", "state"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the person.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the person.",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF number of the person.",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the person.",
 *         example="1234567890"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the person.",
 *         example="123 Main St"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="Postal code (CEP) of the person's address.",
 *         example="12345678"
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="string",
 *         description="Number of the person's address.",
 *         example="12A"
 *     ),
 *     @OA\Property(
 *         property="complement",
 *         type="string",
 *         description="Additional address information.",
 *         example="Apt 3B"
 *     ),
 *     @OA\Property(
 *         property="neighborhood",
 *         type="string",
 *         description="Neighborhood where the person resides.",
 *         example="Downtown"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City where the person resides.",
 *         example="New York"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State where the person resides.",
 *         example="NY"
 *     ),
 *     @OA\Property(
 *         property="supplier",
 *         ref="#/components/schemas/Supplier"
 *     )
 * )
 */

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
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
