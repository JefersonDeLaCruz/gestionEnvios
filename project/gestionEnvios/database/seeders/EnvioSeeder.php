<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Envio;
use App\Models\User;

class EnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Envio::factory()->count(15)->create(); // Aumentado para coincidir con paquetes
    }
}
