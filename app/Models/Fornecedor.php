<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Fornecedor",
 *     type="object",
 *     title="Fornecedor",
 *     description="Modelo que representa um fornecedor",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID do fornecedor",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome do fornecedor",
 *         example="Empresa XYZ"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF do fornecedor (apenas para pessoas físicas)",
 *         example="12345678901"
 *     ),
 *     @OA\Property(
 *         property="cnpj",
 *         type="string",
 *         description="CNPJ do fornecedor (apenas para pessoas jurídicas)",
 *         example="12345678000195"
 *     ),
 *     @OA\Property(
 *         property="endereco_id",
 *         type="integer",
 *         description="ID do endereço associado ao fornecedor",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="endereco",
 *         ref="#/components/schemas/Endereco",
 *         description="Endereço associado ao fornecedor"
 *     ),
 *     @OA\Property(
 *         property="contatos",
 *         type="array",
 *         description="Lista de contatos associados ao fornecedor",
 *         @OA\Items(ref="#/components/schemas/Contato")
 *     )
 * )
 */

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
