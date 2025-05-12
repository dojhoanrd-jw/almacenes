<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Articulo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticuloControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateUser($rol = 'User')
    {
        $user = Usuario::factory()->create(['rol' => $rol]);
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    public function test_usuario_puede_listar_articulos()
    {
        $this->authenticateUser();
        Articulo::factory()->count(3)->create();
        $response = $this->getJson('/api/articulos');
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_usuario_puede_crear_articulo()
    {
        $this->authenticateUser();
        $data = [
            'nombre_articulo' => 'Test Articulo',
            'codigo_barra' => '123456789',
            'precio' => 100,
            'stock' => 10,
            'descripcion' => 'Descripción de prueba',
            'fabricante' => 'Fabricante de prueba',
        ];
        $response = $this->postJson('/api/articulos', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment(['nombre_articulo' => 'Test Articulo']);
        $this->assertDatabaseHas('tblarticulo', ['nombre_articulo' => 'Test Articulo']);
    }

    public function test_validacion_falla_al_crear_articulo()
    {
        $this->authenticateUser();
        $data = [
            // Falta nombre_articulo
            'codigo_barra' => '123456789',
            'precio' => 100,
            'stock' => 10,
        ];
        $response = $this->postJson('/api/articulos', $data);
        $response->assertStatus(422);
    }

    public function test_usuario_puede_actualizar_articulo()
    {
        $this->authenticateUser();
        $articulo = Articulo::factory()->create();
        $data = ['nombre_articulo' => 'Actualizado'];
        $response = $this->putJson("/api/articulos/{$articulo->ArticuloId}", $data);
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre_articulo' => 'Actualizado']);
        $this->assertDatabaseHas('tblarticulo', ['nombre_articulo' => 'Actualizado']);
    }

    public function test_usuario_puede_eliminar_articulo()
    {
        $this->authenticateUser();
        $articulo = Articulo::factory()->create();
        $response = $this->deleteJson("/api/articulos/{$articulo->ArticuloId}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tblarticulo', ['ArticuloId' => $articulo->ArticuloId]);
    }

    public function test_filtros_funcionan_en_listado()
    {
        $this->authenticateUser();
        Articulo::factory()->create(['nombre_articulo' => 'FiltroTest', 'precio' => 50, 'stock' => 5]);
        Articulo::factory()->create(['nombre_articulo' => 'Otro', 'precio' => 200, 'stock' => 20]);
        $response = $this->getJson('/api/articulos?nombre=FiltroTest&precio_min=40&precio_max=100&stock_min=1');
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre_articulo' => 'FiltroTest']);
    }

    public function test_paginacion_funciona()
    {
        $this->authenticateUser();
        Articulo::factory()->count(15)->create();
        $response = $this->getJson('/api/articulos?per_page=10');
        $response->assertStatus(200)
                 ->assertJsonFragment(['per_page' => 10]);
    }
}
