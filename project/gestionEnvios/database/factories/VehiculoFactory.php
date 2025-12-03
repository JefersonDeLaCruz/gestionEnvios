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
        $marcas = ['Toyota', 'Nissan', 'Mitsubishi', 'Hyundai', 'Isuzu', 'Ford', 'Chevrolet'];
        $marca = fake()->randomElement($marcas);

        // Modelos según la marca
        $modelos = [
            'Toyota' => ['Hilux', 'Land Cruiser', 'Hiace'],
            'Nissan' => ['Frontier', 'Navara', 'Urvan'],
            'Mitsubishi' => ['L200', 'Montero', 'Canter'],
            'Hyundai' => ['Porter', 'H100', 'Starex'],
            'Isuzu' => ['D-Max', 'NPR', 'ELF'],
            'Ford' => ['Ranger', 'F-150', 'Transit'],
            'Chevrolet' => ['Colorado', 'Silverado', 'N300'],
        ];

        return [
            'tipo_vehiculo_id' => TipoVehiculo::inRandomOrder()->first()?->id ?? TipoVehiculo::factory(),
            'numero_placas' => fake()->unique()->regexify('P-[0-9]{6}'), // Formato: P-123456
            'marca' => $marca,
            'modelo' => fake()->randomElement($modelos[$marca]),
            'capacidad_kg' => fake()->randomFloat(2, 500, 5000), // Capacidad más realista
            'capacidad_m3' => fake()->randomFloat(2, 2, 15), // Capacidad volumétrica más realista
            'disponible' => fake()->boolean(80), // 80% de probabilidad de estar disponible
        ];
    }
}