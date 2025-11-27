<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnvioCliente>
 */
class EnvioClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => fake()->numberBetween(1, 10),
            'paquete_id' => fake()->numberBetween(1, 10),
            'tipo_cliente' => fake()->randomElement(['emisor', 'receptor']),
        ];
    }
}
