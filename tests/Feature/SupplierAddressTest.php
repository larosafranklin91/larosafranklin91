<?php

use App\Models\Supplier;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate:fresh --seed');
    $this->artisan('cache:clear');
});

describe('SupplierAddressTest', function () {

    it('should return a supplier with addresses', function () {
        $supplier = \App\Models\Supplier::factory()->create([
            "registration_number" => "33.938.861/0001-74",
        ]);

        $address = \App\Models\Address::factory()->make();

        $response = $this->postJson(route('suppliers.addresses.store', $supplier->id), $address->toArray());

        $response->assertStatus(201);
    });

    it('should attach a supplier address', function () {
        $dataSupplier = \App\Models\Supplier::factory()->make([
            "registration_number" => "33.938.861/0001-74",
        ]);

        $address = Address::factory()->make();

        $supplier = $this->postJson(route('suppliers.store'), $dataSupplier->toArray());

        $response = $this->postJson(
            route('suppliers.addresses.store', ['supplier' => $supplier->json('data.id')]),
            $address->toArray()
        );

        $supplierWithAddress = $this->getJson(
            route(
                'suppliers.show',
                [
                    'supplier' => $supplier->json('data.id'),
                    'include' => 'addresses'
                ]
            )
        );

        expect($supplierWithAddress->status())->toBe(200)
            ->and($supplierWithAddress->json('data.addresses'))->not()->toBeEmpty()
            ->and($supplier->status())->toBe(201)
            ->and($response->status())->toBe(201);

    });

    it('should dettach a supplier address', function () {
        $dataSupplier = \App\Models\Supplier::factory()->make([
            "registration_number" => "33.938.861/0001-74",
        ]);

        $address = Address::factory()->make();

        $supplier = $this->postJson(route('suppliers.store'), $dataSupplier->toArray());

        $addAddress = $this->postJson(
            route('suppliers.addresses.store', ['supplier' => $supplier->json('data.id')]),
            $address->toArray()
        );

        $response = $this->deleteJson(
            route(
                'suppliers.addresses.destroy',
                [
                    'supplier' => $supplier->json('data.id'), 'address' => $addAddress->json('data.id')
                ]
            ),

            $address->toArray()
        );

        $supplierWithAddress = $this->getJson(
            route(
                'suppliers.show',
                [
                    'supplier' => $supplier->json('data.id'),
                    'include' => 'addresses'
                ]
            )
        );

        expect($supplierWithAddress->status())->toBe(200)
            ->and($supplierWithAddress->json('data.addresses'))->toBeEmpty()
            ->and($supplier->status())->toBe(201)
            ->and($addAddress->status())->toBe(201)
            ->and($response->status())->toBe(204);
    });

});
