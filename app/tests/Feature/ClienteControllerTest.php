<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateUser($rol = 'User')
    {
        $user = Usuario::factory()->create(['rol' => $rol]);
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    public function test_usuario_puede_listar_clientes()
    {
        $this->authenticateUser();
        Cliente::factory()->count(3)->create();
        $response = $this->getJson('/api/clientes');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_usuario_puede_crear_cliente()
    {
        $this->authenticateUser();
        $data = [
            'nombre' => 'Cliente Test',
            'email' => 'cliente@test.com',
            'telefono' => '123456789',
            'tipo_cliente' => 'Regular', // <--- agrega este campo
            // Agrega aquí los demás campos requeridos por tu validación/modelo
        ];
        $response = $this->postJson('/api/clientes', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['nombre' => 'Cliente Test']);
        $this->assertDatabaseHas('tblcliente', ['nombre' => 'Cliente Test']);
    }

    public function test_validacion_falla_al_crear_cliente()
    {
        $this->authenticateUser();
        $data = [
            // Falta nombre
            'email' => 'cliente@test.com',
        ];
        $response = $this->postJson('/api/clientes', $data);
        $response->assertStatus(422);
    }

    public function test_usuario_puede_actualizar_cliente()
    {
        $this->authenticateUser();
        $cliente = Cliente::factory()->create();
        $data = ['nombre' => 'Actualizado'];
        $response = $this->putJson("/api/clientes/{$cliente->ClienteId}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Actualizado']);
        $this->assertDatabaseHas('tblcliente', ['nombre' => 'Actualizado']);
    }

    public function test_usuario_puede_eliminar_cliente()
    {
        $this->authenticateUser();
        $cliente = Cliente::factory()->create();
        $response = $this->deleteJson("/api/clientes/{$cliente->ClienteId}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tblcliente', ['ClienteId' => $cliente->ClienteId]);
    }

    public function test_filtros_funcionan_en_listado()
    {
        $this->authenticateUser();
        Cliente::factory()->create(['nombre' => 'FiltroTest', 'telefono' => '111111']);
        Cliente::factory()->create(['nombre' => 'Otro', 'telefono' => '222222']);
        $response = $this->getJson('/api/clientes?nombre=FiltroTest');
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'FiltroTest']);
    }

    public function test_paginacion_funciona()
    {
        $this->authenticateUser();
        Cliente::factory()->count(15)->create();
        $response = $this->getJson('/api/clientes?per_page=10');
        $response->assertStatus(200)
                 ->assertJsonFragment(['per_page' => 10]);
    }
}
