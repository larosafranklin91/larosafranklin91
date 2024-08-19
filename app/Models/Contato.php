<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Contato",
 *     type="object",
 *     title="Contato",
 *     description="Modelo que representa um contato associado a um fornecedor",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID do contato",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email do contato",
 *         example="contato@empresa.com"
 *     ),
 *     @OA\Property(
 *         property="telefone",
 *         type="string",
 *         description="Telefone do contato",
 *         example="11987654321"
 *     ),
 *     @OA\Property(
 *         property="fornecedor_id",
 *         type="integer",
 *         description="ID do fornecedor associado a este contato",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="fornecedor",
 *         ref="#/components/schemas/Fornecedor",
 *         description="Fornecedor associado a este contato"
 *     )
 * )
 */

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';

    protected $fillable = [
        'email',
        'telefone',
        'fornecedor_id'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
