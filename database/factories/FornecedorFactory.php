<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition()
    {
        // Gera um CNPJ
        $validCnpj = generateCNPJ();

        return [
            'nome' => $this->faker->company,
            'documento' => $validCnpj,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'endereco' => $this->faker->address,
            'ativo' => true,
        ];
    }
}
