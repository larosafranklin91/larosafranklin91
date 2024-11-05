<?php

use App\Models\Supplier;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate:fresh --seed');
    $this->artisan('cache:clear');
});

describe('SupplierPhoneTest', function () {

    it('should return a supplier with phone', function () {
        $supplier = $this->postJson(
            route('suppliers.store'),
            Supplier::factory()->make([
                "registration_number" => "33.938.861/0001-74",
            ])->toArray()
        );

        $response = $this->postJson(
            route('suppliers.telephones.store', [
                    'supplier' => $supplier->json('data.id')
                ]
            ),
            ['number' => '11999999999']
        );

        $supplierWithPhone = $this->getJson(
            route(
                'suppliers.show',
                [
                    'supplier' => $supplier->json('data.id'),
                    'include' => 'telephones'
                ]
            )
        );

        expect($response->status())->toBe(201)
            ->and($supplier->status())->toBe(201)
            ->and($supplierWithPhone->status())->toBe(200)
            ->and($supplierWithPhone->json('data.telephones'))->not()->toBeEmpty();
    });


    it('should detach a supplier phone', function () {
        $dataSupplier = \App\Models\Supplier::factory()->make([
            "registration_number" => "33.938.861/0001-74",
        ]);

        $telephone = \App\Models\Telephone::factory()->make([
            'number' => '11999999999'
        ]);

        $supplier = $this->postJson(route('suppliers.store'), $dataSupplier->toArray());

        $addPhone = $this->postJson(
            route('suppliers.telephones.store', ['supplier' => $supplier->json('data.id')]),
            $telephone->toArray()
        );

        $response = $this->deleteJson(
            route(
                'suppliers.telephones.destroy',
                [
                    'supplier' => $supplier->json('data.id'), 'telephone' => $addPhone->json('data.id')
                ]
            )
        );

        $supplierWithPhones = $this->getJson(
            route(
                'suppliers.show',
                [
                    'supplier' => $supplier->json('data.id'),
                    'include' => 'telephones'
                ]
            )
        );

        expect($supplierWithPhones->status())->toBe(200)
            ->and($supplierWithPhones->json('data.addresses'))->toBeEmpty()
            ->and($supplier->status())->toBe(201)
            ->and($addPhone->status())->toBe(201)
            ->and($response->status())->toBe(204);
    });

});
