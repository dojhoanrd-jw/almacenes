<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Factura;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacturaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateUser($rol = 'User')
    {
        $user = Usuario::factory()->create(['rol' => $rol]);
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    public function test_usuario_puede_listar_facturas()
    {
        $this->authenticateUser();
        Factura::factory()->count(3)->create();
        $response = $this->getJson('/api/facturas');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_usuario_puede_crear_factura()
    {
        $this->authenticateUser();
        $cliente = \App\Models\Cliente::factory()->create();
        $data = [
            'ClienteId' => $cliente->ClienteId,
            'fecha' => now()->toDateString(),
            'total' => 100.50,
        ];
        $response = $this->postJson('/api/facturas', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['total' => 100.50]);
        $this->assertDatabaseHas('tblfactura', ['total' => 100.50]);
    }

    public function test_validacion_falla_al_crear_factura()
    {
        $this->authenticateUser();
        $data = [
            // Falta campo obligatorio
            'total' => 100.50,
        ];
        $response = $this->postJson('/api/facturas', $data);
        $response->assertStatus(422);
    }

    public function test_usuario_puede_actualizar_factura()
    {
        $this->authenticateUser();
        $factura = Factura::factory()->create();
        $data = ['total' => 200.00];
        $response = $this->putJson("/api/facturas/{$factura->FacturaId}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['total' => 200.00]);
        $this->assertDatabaseHas('tblfactura', ['total' => 200.00]);
    }

    public function test_usuario_puede_eliminar_factura()
    {
        $this->authenticateUser();
        $factura = Factura::factory()->create();
        $response = $this->deleteJson("/api/facturas/{$factura->FacturaId}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tblfactura', ['FacturaId' => $factura->FacturaId]);
    }

    public function test_filtros_funcionan_en_listado()
    {
        $this->authenticateUser();
        Factura::factory()->create(['total' => 500]);
        Factura::factory()->create(['total' => 100]);
        $response = $this->getJson('/api/facturas?total_min=400');
        $response->assertStatus(200)
                 ->assertJsonFragment(['total' => "500.00"]); // El valor puede venir como string
        $response->assertJsonStructure(['data', 'meta']);
    }

    public function test_paginacion_funciona()
    {
        $this->authenticateUser();
        Factura::factory()->count(15)->create();
        $response = $this->getJson('/api/facturas?per_page=10');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'meta']);
        $this->assertEquals(10, $response->json('meta.per_page'));
    }
}
