<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoEnvio;

class EstadoEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Pendiente
        // En ruta
        // Entregado

        EstadoEnvio::create([
            'nombre' => 'En bodega',
            'slug' => 'en-bodega',
            'es_final' => false,
        ]);

        EstadoEnvio::create([
            'nombre' => 'Asignado',
            'slug' => 'asignado',
            'es_final' => false,
        ]);

        EstadoEnvio::create([
            'nombre' => 'En ruta',
            'slug' => 'en-ruta',
            'es_final' => false,
        ]);

        EstadoEnvio::create([
            'nombre' => 'Entregado',
            'slug' => 'entregado',
            'es_final' => true,
        ]);

        EstadoEnvio::create([
            'nombre' => 'No Entregado',
            'slug' => 'no-entregado',
            'es_final' => true,
        ]);
    }
}
