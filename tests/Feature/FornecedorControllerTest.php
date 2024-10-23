<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Fornecedor;
use Illuminate\Support\Facades\Cache;

class FornecedorControllerTest extends TestCase
{
    use RefreshDatabase; // Reseta o banco de dados após cada teste

    /** @test */
    public function it_can_create_a_fornecedor()
    {
        $data = [
            'nome' => 'Fornecedor Teste',
            'documento' => '12345678000195',
            'telefone' => '11999999999',
            'email' => 'fornecedor@teste.com',
            'endereco' => 'Rua Teste, 123',
        ];

        $response = $this->postJson(route('fornecedores.store'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('fornecedores', $data);
    }

    /** @test */
    public function it_can_list_fornecedores()
    {
        // Cache::flush(); // Limpa o cache antes do teste

        Fornecedor::factory()->count(3)->create();

        $response = $this->getJson(route('fornecedores.index'));
         // Debugando a resposta
    // dd($response->json());

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data'); // Verifica se 3 fornecedores foram retornados
    }

    /** @test */
    public function it_can_show_a_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();

        $response = $this->getJson(route('fornecedores.show', $fornecedor->documento));

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'nome' => $fornecedor->nome,
                     'documento' => $fornecedor->documento,
                 ]);
    }

    /** @test */
    public function it_can_update_a_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();

        $data = ['nome' => 'Fornecedor Atualizado'];

        $response = $this->patchJson(route('fornecedores.update', $fornecedor->documento), $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('fornecedores', $data);
    }

    /** @test */
    public function it_can_soft_delete_a_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();
    
        $response = $this->deleteJson(route('fornecedores.destroy', $fornecedor->documento));
    
        $response->assertStatus(200)
                 ->assertJson(['status' => 'Fornecedor desativado']);
    
        $this->assertSoftDeleted('fornecedores', ['documento' => $fornecedor->documento]);
    }
}
