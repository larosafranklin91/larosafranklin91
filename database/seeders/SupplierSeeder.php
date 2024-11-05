<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Supplier;
use App\Models\Telephone;
use Database\Factories\SupplierFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierFactory::new()->count(20)->create()->each(function (Supplier $supplier) {

            $supplier->telephones()->saveMany(
                Telephone::factory()->count(2)->make()
            );

            $supplier->addresses()->saveMany(
                Address::factory()->count(1)->make()
            );

        });
    }
}
