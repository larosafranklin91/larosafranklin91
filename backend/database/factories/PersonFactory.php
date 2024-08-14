<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->numerify('###########'),
            'phone' => $this->faker->numerify('###########'),
            'address' => $this->faker->address(),
            'cep' => $this->faker->numerify('########'),
            'number' => $this->faker->bothify('##?'),
            'complement' => $this->faker->randomElement(['Apto', 'Bloco']),
            'neighborhood' => $this->faker->name(),
            'city' => $this->faker->city(),
            'state' => $this->faker->randomElement([
                'AC',
                'AL',
                'AP',
                'AM',
                'BA',
                'CE',
                'DF',
                'ES',
                'GO',
                'MA',
                'MT',
                'MS',
                'MG',
                'PA',
                'PB',
                'PR',
                'PE',
                'PI',
                'RJ',
                'RN',
                'RS',
                'RO',
                'RR',
                'SC',
                'SP',
                'SE',
                'TO',
            ]),
        ];
    }
}
