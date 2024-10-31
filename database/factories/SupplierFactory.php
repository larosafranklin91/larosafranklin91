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

        $typePerson = fake()->randomElement(['F', 'J']);
        if ($typePerson === 'F') {
            $pattern = "/\b(?:Sr\.|Dr\.|Sra\.|Srta\.|Dr\.)\s*/i";
            $name = fake('pt_BR')->name();
            $name = preg_replace($pattern, '', $name);
        }

        return [
            'supplier_name' => $typePerson === 'F' ? $name : fake('pt_BR')->company,
            'identity_document' => $typePerson === 'F' ? fake('pt_BR')->cpf(false) : fake('pt_BR')->cnpj(false),
            'email' => fake('pt_BR')->unique()->safeEmail,
            'supply_cep' => str_replace('-', '', fake('pt_BR')->postcode()),
            'supply_city' => fake('pt_BR')->city,
            'supply_state' => fake('pt_BR')->stateAbbr,
            'supply_address' => fake('pt_BR')->streetName,
            'supply_address_complement' => fake('pt_BR')->buildingNumber,
            'phone' => preg_replace('/[()\- ]/', '', fake('pt_BR')->cellphoneNumber),
            'birthdate' => $typePerson === 'F' ? fake()->dateTimeBetween('-80 years', '-20 years') : null,
            'type_person' => $typePerson,
        ];
    }
}
