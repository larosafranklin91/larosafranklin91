<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'company_name',
        'trading_name',
        'active',
        'registration_number',
        'cnae',
        'juridic_kind',
        'parent_company',
        'parent_id',
    ];


    protected $attributes = [
        'active' => true,
        'parent_company' => false,
        'juridic_kind' => null,
        'parent_id' => null,
        'cnae' => null,
    ];

    /**
     * @return BelongsToMany
     */
    public function telephones(): BelongsToMany
    {
        return $this->belongsToMany(Telephone::class, SupplierTelephone::class);
    }

    /**
     * @return BelongsToMany
     */
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, SupplierAddress::class);
    }

    public function registrationNumber(): Attribute
    {
        return Attribute::get(
            fn() => preg_replace("/[^0-9]/", "", $this->attributes['registration_number'])
        );
    }

}
