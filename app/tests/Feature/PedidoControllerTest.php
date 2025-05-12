<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Articulo;
use App\Models\Factura;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PedidoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateUser($rol = 'User')
    {
        $user = Usuario::factory()->create(['rol' => $rol]);
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    public function test_usuario_puede_listar_pedidos()
    {
        $this->authenticateUser();
        Pedido::factory()->count(3)->create();
        $response = $this->getJson('/api/pedidos');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_usuario_puede_crear_pedido()
    {
        $this->authenticateUser();
        $cliente = Cliente::factory()->create();
        $factura = Factura::factory()->create(['ClienteId' => $cliente->ClienteId]);
        $articulo = Articulo::factory()->create();
        $data = [
            'FacturaId' => $factura->FacturaId,
            'ArticuloId' => $articulo->ArticuloId,
            'cantidad' => 2,
            'precio' => 50.00,
            'colocacion' => 'Almacen A',
        ];
        $response = $this->postJson('/api/pedidos', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['cantidad' => 2]);
        $this->assertDatabaseHas('tblpedido', ['cantidad' => 2]);
    }

    public function test_validacion_falla_al_crear_pedido()
    {
        $this->authenticateUser();
        $data = [
            'cantidad' => 2,
        ];
        $response = $this->postJson('/api/pedidos', $data);
        $response->assertStatus(422);
    }

    public function test_usuario_puede_actualizar_pedido()
    {
        $this->authenticateUser();
        $pedido = Pedido::factory()->create();
        $data = ['cantidad' => 5];
        $response = $this->putJson("/api/pedidos/{$pedido->PedidoId}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['cantidad' => 5]);
        $this->assertDatabaseHas('tblpedido', ['cantidad' => 5]);
    }

    public function test_usuario_puede_eliminar_pedido()
    {
        $this->authenticateUser();
        $pedido = Pedido::factory()->create();
        $response = $this->deleteJson("/api/pedidos/{$pedido->PedidoId}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tblpedido', ['PedidoId' => $pedido->PedidoId]);
    }

    public function test_filtros_funcionan_en_listado()
    {
        $this->authenticateUser();
        Pedido::factory()->create(['cantidad' => 10]);
        Pedido::factory()->create(['cantidad' => 2]);
        $response = $this->getJson('/api/pedidos?cantidad_min=5');
        $response->assertStatus(200)
                 ->assertJsonFragment(['cantidad' => 10])
                 ->assertJsonStructure(['data', 'meta']);
    }

    public function test_paginacion_funciona()
    {
        $this->authenticateUser();
        Pedido::factory()->count(15)->create();
        $response = $this->getJson('/api/pedidos?per_page=10');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'meta']);
        $this->assertEquals(10, $response->json('meta.per_page'));
    }
}
