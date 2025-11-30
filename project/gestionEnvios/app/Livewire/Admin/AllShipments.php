<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Envio;
use App\Models\EstadoEnvio;

class AllShipments extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Envio::with([
            'paquete',
            'paquete.envioClientes.cliente',
            'estadoEnvio',
            'motorista',
            'vehiculo'
        ]);

        if ($this->search) {
            $query->whereHas('paquete', function ($q) {
                $q->where('codigo', 'like', '%' . $this->search . '%')
                    ->orWhereHas('envioClientes.cliente', function ($cq) {
                        $cq->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->statusFilter) {
            $query->where('estado_envio_id', $this->statusFilter);
        }

        $shipments = $query->latest()->paginate(10);
        $statuses = EstadoEnvio::all();

        return view('livewire.admin.all-shipments', [
            'shipments' => $shipments,
            'statuses' => $statuses
        ])->layout('layout.base-drawer');
    }
}
