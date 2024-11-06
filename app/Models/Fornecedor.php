<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    // Define o nome da tabela, se não seguir a convenção (que seria 'fornecedores')
    protected $table = 'fornecedores';

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'tipo',
        'documento',
        'contato',
        'endereco',
    ];

    // Se necessário, você pode adicionar mais métodos, relações, etc.
}
?>