<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    private array $juridicKinds = [
        '201-1', '203-8', '204-6', '205-4', '206-2', '207-0', '208-9', '209-7',
        '212-7', '213-5', '214-3', '215-1', '216-0', '217-8', '219-4', '221-6',
        '222-4', '223-2', '224-0', '225-9', '226-7', '227-5', '228-3', '229-1',
        '230-5', '231-3', '232-1', '233-0', '234-8', '235-6',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->sentence(2),
            'trading_name' => $this->faker->sentence(2),
            'active' => $this->faker->boolean(),
            'registration_number' => $this->faker->numerify('##############'),
            'cnae' => $this->faker->numerify('########'),
            'juridic_kind' => $this->faker->randomElement($this->juridicKinds),
            'parent_company' => $this->faker->boolean(),
           // 'parent_id' => null,
        ];
    }
}
