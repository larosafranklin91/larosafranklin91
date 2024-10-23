<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use HasFactory;
    use SoftDeletes; // Habilita o Soft Delete no modelo

    protected $table = 'fornecedores'; 

    protected $fillable = [
        'nome',
        'documento',
        'telefone',
        'email',
        'endereco',
        'ativo'
    ];

    protected $dates = ['deleted_at'];
}
