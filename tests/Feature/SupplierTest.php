<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();
    }

    public function test_user_can_see_all_his_suppliers()
    {
        $this->actingAs($this->user);
        $suppliers = Supplier::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/supplier', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(5);
        $response->assertJson($suppliers->toArray());
    }

    public function test_user_dosent_see_another_user_suppliers()
    {
        $this->actingAs($this->user);
        $anotherUser = User::factory()->create();
        $anotherUserSuppliers = Supplier::factory()->count(5)->create(['user_id' => $anotherUser->id]);
        $currentUserSuppliers = Supplier::factory()->count(2)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/supplier', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2);

        $response->assertJson($currentUserSuppliers->toArray());
    }

    public function test_unauthenticated_user_cant_see_suppliers()
    {
        $response = $this->get('/api/supplier', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_user_can_return_his_supplier()
    {
        $this->actingAs($this->user);
        $supplier = Supplier::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get("/api/supplier/{$supplier->id}", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJson($supplier->toArray());
    }

    public function test_user_cant_return_another_user_supplier()
    {
        $this->actingAs($this->user);
        $anotherUser = User::factory()->create();
        $anotherUserSupplier = Supplier::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->get("/api/supplier/{$anotherUserSupplier->id}", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Supplier not found']);
    }

    public function test_user_cant_return_unexistent_supplier()
    {
        $this->actingAs($this->user);

        $response = $this->get("/api/supplier/1", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Supplier not found']);
    }

    public function test_user_can_create_new_supplier()
    {
        $this->actingAs($this->user);

        $data = [
            'supplier' => [
                'fantasy_name' => 'Ortiz PLC',
                'company_name' => 'Nikolaus, Nitzsche and Waters Ltda',
                'cnpj' => '01755944465392',
                'email' => 'consuelo.mitchell@example.com',
                'phone' => '+1-806-487-2962',
                'responsible' => 'Forest Wintheiser MD',
                'status' => 'Disabled',
            ],
            'address' => [
                'cep' => '12345-678',
                'state' => 'SP',
                'city' => 'São Paulo',
                'district' => 'Jardim Paulista',
                'address' => 'Av. Paulista',
                'number' => 1000,
                'complement' => 'Conjunto 1001',
            ],
        ];

        $response = $this->post('/api/supplier', $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'fantasy_name' => 'Ortiz PLC',
            'company_name' => 'Nikolaus, Nitzsche and Waters Ltda',
            'cnpj' => '01755944465392',
            'email' => 'consuelo.mitchell@example.com',
            'phone' => '+1-806-487-2962',
            'responsible' => 'Forest Wintheiser MD',
            'status' => 'Disabled',
        ]);
    
        $response->assertJsonFragment([
            'cep' => '12345-678',
            'state' => 'SP',
            'city' => 'São Paulo',
            'district' => 'Jardim Paulista',
            'address' => 'Av. Paulista',
            'number' => 1000,
            'complement' => 'Conjunto 1001',
        ]);
    
        $this->assertDatabaseHas('suppliers', [
            'fantasy_name' => 'Ortiz PLC',
            'cnpj' => '01755944465392',
        ]);
    
        $this->assertDatabaseHas('addresses', [
            'cep' => '12345-678',
            'state' => 'SP',
            'city' => 'São Paulo',
        ]);
    }

    public function test_unauthenticated_user_cant_create_new_supplier()
    {
        $data = [
            'supplier' => [
                'fantasy_name' => 'Ortiz PLC',
                'company_name' => 'Nikolaus, Nitzsche and Waters Ltda',
                'cnpj' => '01755944465392',
                'email' => 'consuelo.mitchell@example.com',
                'phone' => '+1-806-487-2962',
                'responsible' => 'Forest Wintheiser MD',
                'status' => 'Disabled',
            ],
            'address' => [
                'cep' => '12345-678',
                'state' => 'SP',
                'city' => 'São Paulo',
                'district' => 'Jardim Paulista',
                'address' => 'Av. Paulista',
                'number' => 1000,
                'complement' => 'Conjunto 1001',
            ],
        ];


        $response = $this->post('/api/supplier', $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);

        $this->assertDatabaseMissing('suppliers', [
            'fantasy_name' => 'Ortiz PLC',
            'cnpj' => '01755944465392',
        ]);
    }

    public function test_unauthenticated_user_cant_update_supplier()
    {
        $supplier = Supplier::factory()->create();

        $data = [
            'supplier' => [
                'fantasy_name' => 'Ortiz PLC',
                'company_name' => 'Nikolaus, Nitzsche and Waters Ltda',
                'cnpj' => '01755944465392',
                'email' => 'consuelo.mitchell@example.com',
                'phone' => '+1-806-487-2962',
                'responsible' => 'Forest Wintheiser MD',
                'status' => 'Disabled',
            ],
            'address' => [
                'cep' => '12345-678',
                'state' => 'SP',
                'city' => 'São Paulo',
                'district' => 'Jardim Paulista',
                'address' => 'Av. Paulista',
                'number' => 1000,
                'complement' => 'Conjunto 1001',
            ],
        ];

        $response = $this->put("/api/supplier/{$supplier->id}", $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_user_can_update_supplier()
    {
        $this->actingAs($this->user);
        $supplier = Supplier::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'supplier' => [
                'fantasy_name' => 'Ortiz PLC',
                'company_name' => 'Nikolaus, Nitzsche and Waters Ltda',
                'cnpj' => '01755944465392',
                'email' => 'consuelo.mitchell@example.com',
                'phone' => '+1-806-487-2962',
                'responsible' => 'Forest Wintheiser MD',
                'status' => 'Disabled',
            ],
            'address' => [
                'cep' => '12345-678',
                'state' => 'SP',
                'city' => 'São Paulo',
                'district' => 'Jardim Paulista',
                'address' => 'Av. Paulista',
                'number' => 1000,
                'complement' => 'Conjunto 1001',
            ],
        ];

        $response = $this->put("/api/supplier/{$supplier->id}", $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'fantasy_name' => 'Ortiz PLC',
            'cnpj' => '01755944465392',
            'email' => 'consuelo.mitchell@example.com',
            'phone' => '+1-806-487-2962',
            'responsible' => 'Forest Wintheiser MD',
            'status' => 'Disabled',
        ]);
    
        $this->assertDatabaseHas('addresses', [
            'id' => $supplier->address_id,
            'cep' => '12345-678',
            'state' => 'SP',
            'city' => 'São Paulo',
            'district' => 'Jardim Paulista',
            'address' => 'Av. Paulista',
            'number' => 1000,
            'complement' => 'Conjunto 1001',
        ]);

        $response->assertJson(['message' => 'Supplier updated successfully']);

    }

    public function test_user_can_delete_his_supplier()
    {
        $this->actingAs($this->user);
        $supplier = Supplier::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete("/api/supplier/{$supplier->id}", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'Supplier deleted successfully']);

        $this->assertSoftDeleted('suppliers', [
            'id' => $supplier->id,
        ]);
    }

    public function test_user_cant_delete_another_user_supplier()
    {
        $this->actingAs($this->user);
        $anotherUser = User::factory()->create();
        $anotherUserSupplier = Supplier::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->delete("/api/supplier/{$anotherUserSupplier->id}", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'Supplier not found']);
    }

    public function test_unauthenticated_user_cant_delete_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete("/api/supplier/{$supplier->id}");

        
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    private function createUser(): void
    {
        $this->user = User::factory()->create();
    }
}
