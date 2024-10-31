<?php

namespace Tests\Feature;

use App\Models\Supplier;
use Illuminate\Http\Response;
use Tests\TestCase;

class SupplierCrudTest extends TestCase
{
    public function test_can_create_supplier()
    {
        $response = $this->postJson('/api/v1/suppliers', [
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty(Supplier::where('email', 'supplier1@example.com')->first());
        $this->assertEquals('Teste de Fornecedor', Supplier::latest()->first()->supplier_name);
    }

    public function test_can_read_supplier()
    {
        $supplier = Supplier::create([
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_city' => 'Curitiba',
            'supply_state' => 'PR',
            'supply_address' => 'R. Teste',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
            'type_person' => 'F'
        ]);

        $response = $this->getJson('/api/v1/suppliers/' . $supplier->id);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_city' => 'Curitiba',
            'supply_state' => 'PR',
            'supply_address' => 'R. Teste',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'birthdate' => '2000-01-01',
            'type_person' => 'F',
        ]);
    }

    public function test_can_update_supplier()
    {
        $supplier = Supplier::create([
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_city' => 'Curitiba',
            'supply_state' => 'PR',
            'supply_address' => 'R. Teste',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'type_person' => 'F'
        ]);

        $response = $this->putJson('/api/v1/suppliers/' . $supplier->id, [
            'supplier_name' => 'Fornecedor Atualizado',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Fornecedor Atualizado', $supplier->fresh()->supplier_name);
    }

    public function test_can_delete_supplier()
    {
        $supplier = Supplier::create([
            'supplier_name' => 'Teste de Fornecedor',
            'identity_document' => '13759958044',
            'email' => 'supplier1@example.com',
            'supply_cep' => '82560240',
            'supply_city' => 'Curitiba',
            'supply_state' => 'PR',
            'supply_address' => 'R. Teste',
            'supply_address_complement' => '123-A',
            'phone' => '41984653641',
            'type_person' => 'F'
        ]);

        $response = $this->delete('/api/v1/suppliers/' . $supplier->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('suppliers', [
            'id' => $supplier->id,
        ]);
    }

    protected function tearDown(): void
    {
        Supplier::where('email', 'supplier1@example.com')->withTrashed()->forceDelete();
        parent::tearDown();
    }
}
