<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     title="Supplier",
 *     description="Represents a supplier in the system.",
 *     required={"type", "company_industry"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the supplier.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         description="Type of the supplier. Example: 'Pessoa Física' or 'Pessoa Jurídica'.",
 *         example="Pessoa Física"
 *     ),
 *     @OA\Property(
 *         property="company_industry",
 *         type="string",
 *         description="Industry of the supplier's company.",
 *         example="Retail"
 *     ),
 *     @OA\Property(
 *         property="person_id",
 *         type="integer",
 *         description="ID of the related Person if the type is 'Pessoa Física'.",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="legal_entity_id",
 *         type="integer",
 *         description="ID of the related LegalEntity if the type is 'Pessoa Jurídica'.",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="person",
 *         ref="#/components/schemas/Person"
 *     ),
 *     @OA\Property(
 *         property="legalEntity",
 *         ref="#/components/schemas/LegalEntity"
 *     )
 * )
 */

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'company_industry',
        'person_id',
        'legal_entity_id',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function legalEntity(): BelongsTo
    {
        return $this->belongsTo(LegalEntity::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('withPersonAndLegalEntity', function ($builder) {
            $builder->with(['person', 'legalEntity']);
        });
    }
}
