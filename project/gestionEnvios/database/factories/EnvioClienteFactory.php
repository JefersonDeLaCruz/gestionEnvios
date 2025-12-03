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
            'cliente_id' => \App\Models\Cliente::inRandomOrder()->first()?->id ?? \App\Models\Cliente::factory(),
            'paquete_id' => \App\Models\Paquete::inRandomOrder()->first()?->id ?? \App\Models\Paquete::factory(),
            'tipo_cliente' => fake()->randomElement(['emisor', 'receptor']),
        ];
    }
}
