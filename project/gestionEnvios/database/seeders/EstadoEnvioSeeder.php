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
            'nombre' => 'Pendiente',
            'slug' => 'pendiente',
            'es_final' => false,
        ]);

        EstadoEnvio::create([
            'nombre' => 'Enviado',
            'slug' => 'enviado',
            'es_final' => false,
        ]);

        EstadoEnvio::create([
            'nombre' => 'Entregado',
            'slug' => 'entregado',
            'es_final' => true,
        ]);
    }
}
