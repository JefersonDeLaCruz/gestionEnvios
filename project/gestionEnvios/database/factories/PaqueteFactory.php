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
            'peso' => fake()->numberBetween(1, 100),
            'dimensiones' => fake()->numberBetween(1, 100),
            'tipo_envio' => fake()->randomElement(['rapido', 'normal']),

        ];
    }
}
