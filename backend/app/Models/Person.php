<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
