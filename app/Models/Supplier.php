<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'identity_document',
        'email',
        'supply_cep',
        'supply_city',
        'supply_state',
        'supply_address',
        'supply_address_complement',
        'phone',
        'birthdate',
        'type_person'
    ];

    protected $dates = ['birthdate', 'created_at', 'updated_at', 'deleted_at'];

    // protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
