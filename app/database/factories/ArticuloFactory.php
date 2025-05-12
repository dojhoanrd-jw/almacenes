<?php

namespace Database\Factories;

use App\Models\Articulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticuloFactory extends Factory
{
    protected $model = Articulo::class;

    public function definition()
    {
        return [
            'nombre_articulo' => $this->faker->word,
            'codigo_barra' => $this->faker->unique()->ean13,
            'precio' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(1, 100),
            'descripcion' => $this->faker->sentence,
            'fabricante' => $this->faker->company,
        ];
    }
}
