<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialEnvio>
 */
class HistorialEnvioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'envio_id' => fake()->numberBetween(1, 10),
            'estado_envio_id' => fake()->numberBetween(1, 3),
            'comentario' => fake()->text(),
            'foto_url' => fake()->imageUrl(),
        ];
    }
}
