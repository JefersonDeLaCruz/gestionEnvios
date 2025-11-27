<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Envio>
 */
class EnvioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paquete_id' => fake()->numberBetween(1, 10),
            'vehiculo_id' => fake()->numberBetween(1, 10),
            'motorista_id' => fake()->numberBetween(1),
            'estado_envio_id' => fake()->numberBetween(1, 3),
            'fecha_estimada' => fake()->date(),
            'costo' => fake()->numberBetween(1, 500),

        ];
    }
}
