<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company,
            'cpf' => gerarCpfValido(),
            'cnpj' => null,
            'endereco_id' => Endereco::factory(),
        ];
    }
}
