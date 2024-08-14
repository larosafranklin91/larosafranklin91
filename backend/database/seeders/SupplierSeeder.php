<?php

namespace Database\Seeders;

use App\Models\LegalEntity;
use App\Models\Person;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory(['type' => 'Pessoa Física'])
        ->for(Person::factory())
        ->create();

        Supplier::factory(['type' => 'Pessoa Física'])
        ->for(LegalEntity::factory())
        ->create();
    }
}
