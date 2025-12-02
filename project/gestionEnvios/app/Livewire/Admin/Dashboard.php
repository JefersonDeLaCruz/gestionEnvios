<?php

namespace App\Livewire\Admin;

use App\Models\Paquete;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Envio;
use App\Models\HistorialEnvio;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalPaquetes = Paquete::count();
        $usuariosActivos = User::count();
        $vehiculos = Vehiculo::count();
        $ingresosHoy = Envio::whereDate('created_at', Carbon::today())->sum('costo');

        $recentActivity = HistorialEnvio::with(['envio.paquete', 'estadoEnvio'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalPaquetes' => $totalPaquetes,
            'usuariosActivos' => $usuariosActivos,
            'vehiculos' => $vehiculos,
            'ingresosHoy' => $ingresosHoy,
            'recentActivity' => $recentActivity,
        ])->layout('layout.base-drawer');
    }
}
