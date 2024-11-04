<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cnpj_cpf', 'contact', 'address'];

    public static $rules = [
        'name' => 'required|string|max:255',
        'cnpj_cpf' => 'required|string|size:14|unique:suppliers',
        'contact' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
    ];
}
