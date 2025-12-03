<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Envio;
use App\Models\User;
use App\Models\EstadoEnvio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Reports extends Component
{
    use WithPagination;

    public $dateFrom;
    public $dateTo;
    public $selectedDriver = '';
    public $selectedStatus = '';
    public $reportType = 'general'; // general, drivers, deliveries

    protected $paginationTheme = 'daisyui';

    public function mount()
    {
        // Set default dates (last 30 days)
        $this->dateTo = Carbon::now()->format('Y-m-d');
        $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
    }

    public function updatingSelectedDriver()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->dateTo = Carbon::now()->format('Y-m-d');
        $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->selectedDriver = '';
        $this->selectedStatus = '';
        $this->resetPage();
    }

    public function getGeneralStats()
    {
        $query = Envio::query()
            ->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59']);

        $totalDeliveries = $query->count();
        $totalRevenue = $query->sum('costo');
        $completedDeliveries = (clone $query)->whereHas('estadoEnvio', function ($q) {
            $q->where('es_final', true);
        })->count();
        $activeDeliveries = $totalDeliveries - $completedDeliveries;
        $avgDeliveryTime = $query->avg(DB::raw('TIMESTAMPDIFF(HOUR, created_at, updated_at)'));

        return [
            'total_deliveries' => $totalDeliveries,
            'total_revenue' => number_format($totalRevenue, 2),
            'completed_deliveries' => $completedDeliveries,
            'active_deliveries' => $activeDeliveries,
            'avg_delivery_time' => round($avgDeliveryTime, 1),
            'completion_rate' => $totalDeliveries > 0 ? round(($completedDeliveries / $totalDeliveries) * 100, 1) : 0,
        ];
    }

    public function getDriverPerformance()
    {
        $drivers = User::role('repartidor')
            ->withCount([
                'envios as total_deliveries' => function ($q) {
                    $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59']);
                }
            ])
            ->withSum([
                'envios as total_revenue' => function ($q) {
                    $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59']);
                }
            ], 'costo')
            ->withCount([
                'envios as completed_deliveries' => function ($q) {
                    $q->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
                        ->whereHas('estadoEnvio', function ($sq) {
                            $sq->where('es_final', true);
                        });
                }
            ])
            ->having('total_deliveries', '>', 0)
            ->orderByDesc('total_deliveries')
            ->limit(10)
            ->get();

        return $drivers;
    }

    public function getDeliveries()
    {
        $query = Envio::with(['paquete', 'motorista', 'estadoEnvio', 'vehiculo'])
            ->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59']);

        if ($this->selectedDriver) {
            $query->where('motorista_id', $this->selectedDriver);
        }

        if ($this->selectedStatus) {
            $query->where('estado_envio_id', $this->selectedStatus);
        }

        return $query->latest()->paginate(10);
    }

    public function getStatusDistribution()
    {
        $distribution = Envio::select('estado_envio_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$this->dateFrom . ' 00:00:00', $this->dateTo . ' 23:59:59'])
            ->with('estadoEnvio')
            ->groupBy('estado_envio_id')
            ->get();

        return $distribution;
    }

    public $selectedEnvioId = null;
    public $showHistoryModal = false;

    public function viewHistory($envioId)
    {
        $this->selectedEnvioId = $envioId;
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
        $this->selectedEnvioId = null;
    }

    public $selectedImageUrl = null;
    public $showImageModal = false;

    public function viewImage($url)
    {
        $this->selectedImageUrl = $url;
        $this->showImageModal = true;
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->selectedImageUrl = null;
    }

    public function getHistoryProperty()
    {
        if (!$this->selectedEnvioId) {
            return collect();
        }

        return \App\Models\HistorialEnvio::where('envio_id', $this->selectedEnvioId)
            ->with('estadoEnvio')
            ->latest()
            ->get();
    }

    public function render()
    {
        $generalStats = $this->getGeneralStats();
        $driverPerformance = $this->getDriverPerformance();
        $deliveries = $this->getDeliveries();
        $statusDistribution = $this->getStatusDistribution();

        $drivers = User::role('repartidor')->get();
        $statuses = EstadoEnvio::all();

        return view('livewire.admin.reports', [
            'generalStats' => $generalStats,
            'driverPerformance' => $driverPerformance,
            'deliveries' => $deliveries,
            'statusDistribution' => $statusDistribution,
            'drivers' => $drivers,
            'statuses' => $statuses,
            'history' => $this->history,
        ])->layout('layout.base-drawer');
    }
}
