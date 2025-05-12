<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    protected $model = Factura::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ClienteId' => Cliente::factory(),
            'fecha' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
