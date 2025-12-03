<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'apellido' => fake()->lastName(),
            'direccion' => fake()->address(),
            'telefono' => fake()->numerify('####-####'), // Formato salvadoreño
            'email' => fake()->unique()->safeEmail(),
            'dui' => fake()->unique()->numerify('########-#'),
            'nit' => fake()->unique()->numerify('####-######-###-#'),
        ];
    }
}
