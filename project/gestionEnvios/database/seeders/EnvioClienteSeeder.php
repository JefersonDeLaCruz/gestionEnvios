<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EnvioCliente;

class EnvioClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los paquetes y clientes
        $paquetes = \App\Models\Paquete::all();
        $clientes = \App\Models\Cliente::all();

        if ($paquetes->isEmpty() || $clientes->count() < 2) {
            $this->command->warn('⚠ Se necesitan al menos paquetes y 2 clientes para crear envío_clientes.');
            return;
        }

        // Para cada paquete, asignar un emisor y un receptor
        foreach ($paquetes as $paquete) {
            $clientesAleatorios = $clientes->random(2);

            // Crear el emisor
            EnvioCliente::create([
                'cliente_id' => $clientesAleatorios[0]->id,
                'paquete_id' => $paquete->id,
                'tipo_cliente' => 'emisor',
            ]);

            // Crear el receptor
            EnvioCliente::create([
                'cliente_id' => $clientesAleatorios[1]->id,
                'paquete_id' => $paquete->id,
                'tipo_cliente' => 'receptor',
            ]);
        }

        $this->command->info('✓ EnvioClientes creados: ' . ($paquetes->count() * 2) . ' registros (emisor y receptor por paquete)');
    }
}
