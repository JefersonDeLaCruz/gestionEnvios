<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $repartidorRole = Role::firstOrCreate(['name' => 'repartidor']);
        

         // Crear usuario admin de prueba
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gestionenvios.com'],
            [
                'nombre'     => 'Administrador',
                'apellido'   => 'Sistema',
                'telefono'   => '12345678',
                'direccion'  => 'Oficina Central',
                'password'   => Hash::make('admin123'),
            ]
        );

        // Asignar rol admin
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // Crear usuario repartidor de prueba
        $repartidorUser = User::firstOrCreate(
            ['email' => 'repartidor@gestionenvios.com'],
            [
                'nombre'     => 'Juan',
                'apellido'   => 'Repartidor',
                'telefono'   => '87654321',
                'direccion'  => 'Zona 1',
                'password'   => Hash::make('repartidor123'),
            ]
        );

        // Asignar rol repartidor
        if (!$repartidorUser->hasRole('repartidor')) {
            $repartidorUser->assignRole($repartidorRole);
        }

    }
}
