<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Factura;
use App\Models\Articulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'FacturaId' => Factura::factory(),
            'ArticuloId' => Articulo::factory(),
            'cantidad' => $this->faker->numberBetween(1, 10),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'colocacion' => $this->faker->word,
        ];
    }
}
