<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Fornecedor;
use App\Models\Endereco;

class FornecedorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function um_fornecedor_pode_ser_criado()
    {
        $endereco = Endereco::factory()->create();

        $response = $this->post('/fornecedores', [
            'nome' => 'Fornecedor Teste',
            'cpf' => gerarCpfValido(),
            'cnpj' => null,
            'logradouro' => $endereco->logradouro,
            'numero' => $endereco->numero,
            'complemento' => $endereco->complemento,
            'bairro' => $endereco->bairro,
            'cidade' => $endereco->cidade,
            'uf' => $endereco->uf,
            'cep' => $endereco->cep,
            'telefone' => ['41999999999'],
            'email' => ['teste@empresa.com'],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('fornecedores', ['nome' => 'Fornecedor Teste']);
        $this->assertDatabaseHas('enderecos', ['logradouro' => $endereco->logradouro]);
    }

    /** @test */
    public function um_fornecedor_pode_ser_atualizado()
    {
        $fornecedor = Fornecedor::factory()->create();

        $response = $this->put("/fornecedores/{$fornecedor->id}", [
            'nome' => 'Fornecedor Atualizado',
            'cpf' => $fornecedor->cpf,
            'cnpj' => $fornecedor->cnpj,
            'logradouro' => $fornecedor->endereco->logradouro,
            'numero' => $fornecedor->endereco->numero,
            'complemento' => $fornecedor->endereco->complemento,
            'bairro' => $fornecedor->endereco->bairro,
            'cidade' => $fornecedor->endereco->cidade,
            'uf' => $fornecedor->endereco->uf,
            'cep' => $fornecedor->endereco->cep,
            'telefone' => ['41999999999'],
            'email' => ['atualizado@empresa.com'],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('fornecedores', ['nome' => 'Fornecedor Atualizado']);
        $this->assertDatabaseHas('contatos', ['email' => 'atualizado@empresa.com']);
    }
}
