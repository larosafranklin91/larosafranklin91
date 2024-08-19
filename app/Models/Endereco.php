<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Endereco",
 *     type="object",
 *     title="Endereço",
 *     description="Modelo que representa um endereço",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID do endereço",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="logradouro",
 *         type="string",
 *         description="Logradouro do endereço",
 *         example="Rua das Flores"
 *     ),
 *     @OA\Property(
 *         property="numero",
 *         type="string",
 *         description="Número do endereço",
 *         example="123"
 *     ),
 *     @OA\Property(
 *         property="complemento",
 *         type="string",
 *         description="Complemento do endereço",
 *         example="Apto 45"
 *     ),
 *     @OA\Property(
 *         property="bairro",
 *         type="string",
 *         description="Bairro do endereço",
 *         example="Centro"
 *     ),
 *     @OA\Property(
 *         property="cidade",
 *         type="string",
 *         description="Cidade do endereço",
 *         example="São Paulo"
 *     ),
 *     @OA\Property(
 *         property="uf",
 *         type="string",
 *         description="Unidade Federativa (UF) do endereço",
 *         example="SP"
 *     ),
 *     @OA\Property(
 *         property="cep",
 *         type="string",
 *         description="CEP do endereço",
 *         example="01001000"
 *     )
 * )
 */

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
