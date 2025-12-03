<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paquete>
 */
class PaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => fake()->unique()->numberBetween(100000000, 999999999),
            'descripcion' => fake()->sentence(),
            'peso' => fake()->numberBetween(1, 100),
            'longitud' => fake()->longitude(),
            'latitud' =>fake()->latitude(),
            'dimensiones' => fake()->numberBetween(1, 100) . 'x' . fake()->numberBetween(1, 100) . 'x' . fake()->numberBetween(1, 100),
            'tipo_envio_id' => \App\Models\TipoEnvio::inRandomOrder()->first()->id,
        ];
    }
}
