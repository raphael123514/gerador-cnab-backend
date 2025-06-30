<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    /**
     * Testa se a rota protegida retorna 401 quando o usuário não está autenticado.
     *
     * @return void
     */
    public function test_protected_route_returns_401_if_unauthenticated()
    {
        // Faz uma requisição GET para /api/teste esperando JSON, sem token.
        $response = $this->getJson('/api/teste');

        // Verifica se a resposta foi EXATAMENTE o status 401
        $response->assertStatus(401);

        // Verifica se a resposta contém EXATAMENTE a mensagem de "Unauthenticated."
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}