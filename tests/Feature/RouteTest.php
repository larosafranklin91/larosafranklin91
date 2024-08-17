<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    
    /** @test */
    public function test_redireciona_pagina_inicial(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /** @test */
    public function test_consegue_abrir_pagina_fornecedores(): void
    {
        $response = $this->get('/fornecedores');

        $response->assertStatus(200);
    }

}
