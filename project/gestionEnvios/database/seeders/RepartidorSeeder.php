<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\TipoVehiculo;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RepartidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure repartidor role exists
        $repartidorRole = Role::firstOrCreate(['name' => 'repartidor', 'guard_name' => 'web']);

        // Create a delivery driver (repartidor)
        $repartidor = User::create([
            'nombre' => 'Carlos',
            'apellido' => 'Martínez',
            'email' => 'carlos.martinez@delivery.com',
            'telefono' => '7890-1234',
            'direccion' => 'Colonia San Benito, San Salvador',
            'password' => Hash::make('password123'),
        ]);

        // Assign repartidor role
        $repartidor->assignRole('repartidor');

        // Get or create a vehicle type
        $tipoVehiculo = TipoVehiculo::firstOrCreate(
            ['nombre' => 'Camioneta'],
            ['descripcion' => 'Camioneta de carga mediana']
        );

        // Create a vehicle
        $vehiculo = Vehiculo::create([
            'tipo_vehiculo_id' => $tipoVehiculo->id,
            'numero_placas' => 'ABC-1234',
            'marca' => 'Toyota',
            'modelo' => 'Hilux',
            'capacidad_kg' => 1000.00,
            'capacidad_m3' => 5.00,
            'disponible' => true,
        ]);

        // Assign vehicle to driver in pivot table
        $repartidor->vehiculos()->attach($vehiculo->id, [
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✓ Repartidor creado: ' . $repartidor->nombre . ' ' . $repartidor->apellido);
        $this->command->info('✓ Vehículo asignado: ' . $vehiculo->marca . ' ' . $vehiculo->modelo . ' (' . $vehiculo->numero_placas . ')');
    }
}
