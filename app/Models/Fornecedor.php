<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'nome', 
        'cpf', 
        'cnpj', 
        'endereco_id'
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class);
    }
}
