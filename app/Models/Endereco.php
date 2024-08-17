<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    protected $fillable = [
        'logradouro', 
        'numero', 
        'complemento', 
        'bairro', 
        'cidade', 
        'uf', 
        'cep'
    ];

    public function fornecedor()
    {
        return $this->hasOne(Fornecedor::class);
    }
}
