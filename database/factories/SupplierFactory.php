<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'address_id' => Address::factory(),
            'fantasy_name' => $this->faker->company,
            'company_name' => $this->faker->company . ' Ltda',
            'cnpj' => $this->faker->numerify('##############'),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'responsible' => $this->faker->name,
            'status' => $this->faker->randomElement(['Active', 'Disabled']),
        ];
    }
}
