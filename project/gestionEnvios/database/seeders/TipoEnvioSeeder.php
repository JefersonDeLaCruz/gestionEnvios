<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'estandar',
                'prioridad' => 3,
                'tarifa_base' => 100,
                'tarifa_por_kg' => 10,
                'tarifa_por_m3' => 10,
            ],
            [
                'nombre' => 'express',
                'prioridad' => 2,
                'tarifa_base' => 200,
                'tarifa_por_kg' => 20,
                'tarifa_por_m3' => 20,
            ],
            [
                'nombre' => 'overnight',
                'prioridad' => 1,
                'tarifa_base' => 300,
                'tarifa_por_kg' => 30,
                'tarifa_por_m3' => 30,
            ],
            [
                'nombre' => 'premium',
                'prioridad' => 4,
                'tarifa_base' => 400,
                'tarifa_por_kg' => 40,
                'tarifa_por_m3' => 40,
            ],
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoEnvio::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }
    }
}
