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
        // Coordenadas de San Miguel, El Salvador
        // Latitud: aproximadamente 13.45 a 13.51
        // Longitud: aproximadamente -88.22 a -88.14
        $latitud = fake()->randomFloat(6, 13.45, 13.51);
        $longitud = fake()->randomFloat(6, -88.22, -88.14);

        return [
            'codigo' => fake()->unique()->numerify('PKG-########'), // Código más legible
            'descripcion' => fake()->sentence(3),
            'peso' => fake()->randomFloat(2, 0.5, 100), // Peso en kg con decimales
            'latitud' => $latitud,
            'longitud' => $longitud,
            'dimensiones' => fake()->numberBetween(10, 100),// Volumen en cm³
            'tipo_envio_id' => \App\Models\TipoEnvio::inRandomOrder()->first()->id,
        ];
    }
}
