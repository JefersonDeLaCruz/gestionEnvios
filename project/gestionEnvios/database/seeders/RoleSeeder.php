<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear roles
        $admin     = Role::firstOrCreate(['name' => 'admin']);
        $motorista = Role::firstOrCreate(['name' => 'motorista']);
        

         // Crear usuario admin de prueba
        $user = User::firstOrCreate(
            ['email' => 'testadmin@skybox.test'],
            [
                'nombre'     => 'test admin',
                'apellido'   => 'test admin',
                'telefono'   => '12345678',
                'direccion'  => 'Calle 123',
                'email'      => 'testadmin@skybox.test',
                'password'   => bcrypt('12345678'),
            ]
        );

        // asignar rol
        $user->assignRole($admin);

    }
}
