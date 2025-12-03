<?php

namespace Database\Factories;

use App\Models\TipoVehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Seleccionar un tipo de vehículo existente aleatoriamente
            'tipo_vehiculo_id' => TipoVehiculo::inRandomOrder()->first()?->id ?? TipoVehiculo::factory(),
            'numero_placas' => fake()->unique()->regexify('P [0-9]{3}-[0-9]{3}'),
            'marca' => fake()->word(),
            'modelo' => fake()->word(),
            'capacidad_kg' => fake()->numberBetween(1000, 10000),
            'capacidad_m3' => fake()->numberBetween(1, 10),
            'disponible' => fake()->boolean(),
        ];
    }
}