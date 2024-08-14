<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Pessoa Física', 'Pessoa Jurídica']),
            'company_industry' => $this->faker->randomElement(['Consultoria em ', 'Assessoria em ', 'Extração de ']) . $this->faker->word(),
        ];
    }
}
