<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function getTodayStats()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Pendientes: Asignados al motorista y que no están entregados ni cancelados
        $pendingToday = Envio::where('motorista_id', $user->id)
            ->whereHas('estadoEnvio', function ($q) {
                $q->whereNotIn('slug', ['entregado', 'cancelado']);
            })
            ->count();

        // Completados hoy: Asignados al motorista, entregados, y actualizados hoy
        $completedToday = Envio::where('motorista_id', $user->id)
            ->whereDate('updated_at', $today)
            ->whereHas('estadoEnvio', function ($q) {
                $q->where('slug', 'entregado');
            })
            ->count();

        // Total asignados para hoy (pendientes + completados hoy)
        $totalAssigned = $pendingToday + $completedToday;

        return [
            'total_assigned' => $totalAssigned,
            'completed_today' => $completedToday,
            'pending_today' => $pendingToday,
            'completion_rate' => $totalAssigned > 0 ? round(($completedToday / $totalAssigned) * 100) : 0,
        ];
    }

    public function getActiveRouteInfo()
    {
        $user = Auth::user();

        $pendingEnvios = Envio::where('motorista_id', $user->id)
            ->whereHas('estadoEnvio', function ($q) {
                $q->whereNotIn('slug', ['entregado', 'cancelado']);
            })
            ->orderBy('fecha_estimada')
            ->get();

        if ($pendingEnvios->isEmpty()) {
            return null;
        }

        $startTime = $pendingEnvios->first()->fecha_estimada
            ? Carbon::parse($pendingEnvios->first()->fecha_estimada)->format('h:i A')
            : 'Por definir';

        $endTime = $pendingEnvios->last()->fecha_estimada
            ? Carbon::parse($pendingEnvios->last()->fecha_estimada)->format('h:i A')
            : 'Por definir';

        return [
            'name' => 'Ruta del Día',
            'start_time' => $startTime,
            'end_time' => $endTime,
            'package_count' => $pendingEnvios->count(),
        ];
    }

    public function getUpcomingDeliveries()
    {
        $user = Auth::user();

        return Envio::where('motorista_id', $user->id)
            ->whereHas('estadoEnvio', function ($q) {
                $q->whereNotIn('slug', ['entregado', 'cancelado']);
            })
            ->with(['paquete.envioClientes.cliente', 'estadoEnvio'])
            ->orderBy('fecha_estimada')
            ->take(5)
            ->get();
    }

    public function getRecentHistory()
    {
        $user = Auth::user();
        $today = Carbon::today();

        return Envio::where('motorista_id', $user->id)
            ->whereDate('updated_at', $today)
            ->with(['paquete', 'estadoEnvio'])
            ->latest('updated_at')
            ->take(6)
            ->get();
    }

    public function render()
    {
        $stats = $this->getTodayStats();
        $upcomingDeliveries = $this->getUpcomingDeliveries();
        $recentHistory = $this->getRecentHistory();
        $activeRoute = $this->getActiveRouteInfo();

        return view('livewire.repartidor.dashboard', [
            'stats' => $stats,
            'upcomingDeliveries' => $upcomingDeliveries,
            'recentHistory' => $recentHistory,
            'activeRoute' => $activeRoute,
        ])
            ->layout('layout.base-drawer');
    }
}
