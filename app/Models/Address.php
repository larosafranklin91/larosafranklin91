<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'complement',
        'zip_code',
        'neighborhood',
        'city',
        'state',
    ];

    protected $attributes = [
        'complement' => null,
        'number' => null,
    ];

    public function fullAddress(): Attribute
    {
        $number = $this->number ? ", {$this->number}" : ' s/n';
        $complement = $this->complement ? " - {$this->complement}" : '';

        return Attribute::get(
            fn() => "{$this->street}{$number}{$complement} - {$this->neighborhood}, {$this->city} - {$this->state}",
        );
    }

    public function zipCode(): Attribute
    {
        return Attribute::set(
            fn($value) => preg_replace('/[^0-9]/', '', $value),
        );
    }
}
