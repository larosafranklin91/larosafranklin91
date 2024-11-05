<?php
beforeEach(function () {
    $this->artisan('migrate:fresh --seed');
});

describe('Supplier CRUD Test', function () {
    it('should return a list of suppliers', function () {
        $response = $this->getJson(route('suppliers.index'));

        $response->assertStatus(200);
    });

    it('should return a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->create([
            'registration_number' => '33.938.861/0001-74'
        ]);

        $response = $this->getJson(route('suppliers.show', $supplier->id));

        $response->assertStatus(200);
    });

    it('should create a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->make([
            'registration_number' => '33.938.861/0001-74'
        ]);

        $response = $this->postJson(route('suppliers.store'), $supplier->toArray());

       expect($response->status())->toBe(201);
    });

    it('should update a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->create([
            'registration_number' => '33.938.861/0001-74'
        ]);

        $newSupplier = \App\Models\Supplier::factory()->make([
            'registration_number' => '33.938.861/0001-74'
        ]);

        $response = $this->putJson(route('suppliers.update', $supplier->id), $newSupplier->toArray());
        expect($response->status())->toBe(200);
    });

    it('should delete a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->create();

        $response = $this->deleteJson(route('suppliers.destroy', $supplier->id));

       expect($response->status())->toBe(204);
    });

    // Testes de falha de validação

    it('should return a validation error when creating a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->make([
            'registration_number' => '000000000000000'
        ]);

        $response = $this->postJson(route('suppliers.store'), $supplier->toArray());

        $response->assertStatus(404);
    });

    it('should return a validation error when updating a supplier', function () {
        $supplier = \App\Models\Supplier::factory()->create([
            'registration_number' => '33.938.861/0001-74'
        ]);

        $newSupplier = \App\Models\Supplier::factory()->make([
            'registration_number' => '0000000000000'
        ]);

        $response = $this->putJson(route('suppliers.update', $supplier->id), $newSupplier->toArray());

        $response->assertStatus(404);
    });

    it('should return a validation error when deleting a supplier', function () {
        $response = $this->deleteJson(route('suppliers.destroy', 0));

        $response->assertStatus(404);
    });

    it('should test a valid CNPJ but that dont exists on Receita Federal', function () {
        $supplier = \App\Models\Supplier::factory()->make([
            'registration_number' => '00.000.000/0000-00'
        ]);

        $response = $this->postJson(route('suppliers.store'), $supplier->toArray());

        $response->assertStatus(404);
    });
});
