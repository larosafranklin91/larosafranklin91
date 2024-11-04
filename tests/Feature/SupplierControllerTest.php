<?php

namespace Tests\Feature;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase; // Para usar a migração e o rollback após os testes

    public function test_index_returns_suppliers()
    {
        $suppliers = Supplier::factory()->count(5)->create();

        $response = $this->getJson(route('suppliers.index'));

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_index_filters_suppliers()
    {
        $supplier = Supplier::factory()->create(['name' => 'Test Supplier']);
        Supplier::factory()->create(['name' => 'Another Supplier']);

        $response = $this->getJson(route('suppliers.index', ['search' => 'Test']));

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Supplier'])
            ->assertJsonMissing(['name' => 'Another Supplier']);
    }

    public function test_store_creates_supplier()
    {
        $data = [
            'name' => 'New Supplier',
            'contact' => 'contact@example.com',
            // Adicione outros campos necessários conforme seu modelo Supplier
        ];

        $response = $this->postJson(route('suppliers.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('suppliers', $data);
    }

    public function test_show_returns_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->getJson(route('suppliers.show', $supplier->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $supplier->name]);
    }

    public function test_show_returns_not_found_for_non_existing_supplier()
    {
        $response = $this->getJson(route('suppliers.show', 999));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Supplier not found.']);
    }

    public function test_update_updates_supplier()
    {
        $supplier = Supplier::factory()->create();

        $data = [
            'name' => 'Updated Supplier',
            // Adicione outros campos necessários conforme seu modelo Supplier
        ];

        $response = $this->putJson(route('suppliers.update', $supplier->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('suppliers', $data);
    }

    public function test_update_returns_not_found_for_non_existing_supplier()
    {
        $data = ['name' => 'Some Name'];

        $response = $this->putJson(route('suppliers.update', 999), $data);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Supplier not found.']);
    }

    public function test_destroy_deletes_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson(route('suppliers.destroy', $supplier->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }

    public function test_destroy_returns_not_found_for_non_existing_supplier()
    {
        $response = $this->deleteJson(route('suppliers.destroy', 999));

        $response->assertStatus(404)
            ->assertJson(['error' => 'Supplier not found.']);
    }
}
