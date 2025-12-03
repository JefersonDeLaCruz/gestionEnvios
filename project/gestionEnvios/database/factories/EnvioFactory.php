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
            'paquete_id' => \App\Models\Paquete::inRandomOrder()->first()->id ?? \App\Models\Paquete::factory(),
            'vehiculo_id' => \App\Models\Vehiculo::inRandomOrder()->first()->id ?? \App\Models\Vehiculo::factory(),
            'motorista_id' => \App\Models\User::role('repartidor')->inRandomOrder()->first()->id ?? \App\Models\User::factory(),
            'estado_envio_id' => \App\Models\EstadoEnvio::inRandomOrder()->first()->id ?? \App\Models\EstadoEnvio::factory(),
            'fecha_estimada' => now(), // Fecha estimada de hoy
            'costo' => fake()->randomFloat(2, 10, 500),
        ];
    }
}
