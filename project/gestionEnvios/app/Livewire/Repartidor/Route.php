<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

class Route extends Component
{
    public $envios;
    public $stats = [];
    public $selectedEnvio = null;

    public $filter = 'pendientes';

    public function mount()
    {
        $this->loadEnvios();
    }

    public function loadEnvios()
    {
        $user = auth()->user();

        // Ensure user has the correct role
        if (!$user || !$user->hasRole('repartidor')) {
            $this->envios = collect();
            return;
        }

        $this->envios = \App\Models\Envio::with([
            'paquete',
            'estadoEnvio',
            'historialEnvios',
            'paquete.tipoEnvio',
            'paquete.envioClientes.cliente'
        ])
            ->where('motorista_id', $user->id)
            ->get()
            ->sortBy(function ($envio) {
                // Sort by priority (1 is highest), then by creation date
                return [
                    $envio->paquete->tipoEnvio->prioridad ?? 999,
                    $envio->created_at
                ];
            });

        // Calculate statistics
        $total = $this->envios->count();
        $entregados = $this->envios->filter(fn($e) => ($e->estadoEnvio->slug ?? '') === 'entregado')->count();
        // Pendientes are those that are not final (not delivered and not failed)
        $pendientes = $this->envios->filter(fn($e) => !($e->estadoEnvio->es_final ?? false))->count();
        $progreso = $total > 0 ? round(($entregados / $total) * 100) : 0;

        $this->stats = [
            'total' => $total,
            'entregados' => $entregados,
            'pendientes' => $pendientes,
            'progreso' => $progreso
        ];
    }

    public function getFilteredEnviosProperty()
    {
        return $this->envios->filter(function ($envio) {
            $slug = $envio->estadoEnvio->slug ?? '';
            $esFinal = $envio->estadoEnvio->es_final ?? false;

            return match ($this->filter) {
                'entregados' => $slug === 'entregado',
                'pendientes' => !$esFinal, // Shows asignado, en-ruta, en-bodega
                'fallidos' => $slug === 'no-entregado',
                default => true, // 'todos'
            };
        })->values();
    }

    public function getReceptor($envio)
    {
        if (!$envio || !$envio->paquete || !$envio->paquete->envioClientes) {
            return null;
        }

        $envioCliente = $envio->paquete->envioClientes
            ->where('tipo_cliente', 'receptor')
            ->first();

        return $envioCliente ? $envioCliente->cliente : null;
    }

    public function selectEnvio($envioId)
    {
        $this->selectedEnvio = $this->envios->firstWhere('id', $envioId);

        $receptor = $this->getReceptor($this->selectedEnvio);
        $address = $receptor->direccion ?? ($this->selectedEnvio->paquete->direccion ?? 'Ubicación del paquete');

        // Dispatch event for map update if needed
        $this->dispatch('envioSelected', [
            'lat' => $this->selectedEnvio->paquete->latitud,
            'lng' => $this->selectedEnvio->paquete->longitud,
            'address' => $address
        ]);
    }

    use \Livewire\WithFileUploads;

    public $showModal = false;
    public $newStatusId;
    public $comment;
    public $photo;
    public $canAssignEnRuta = true;
    public $capacityMessage = '';

    public function openModal($envioId, $statusSlug)
    {
        $this->selectedEnvio = $this->envios->firstWhere('id', $envioId);
        $estado = \App\Models\EstadoEnvio::where('slug', $statusSlug)->first();

        if ($this->selectedEnvio && $estado) {
            $this->newStatusId = $estado->id;
            $this->comment = '';
            $this->photo = null;
            $this->showModal = true;

            // Check capacity
            $this->checkCapacity();
        }
    }

    public function checkCapacity()
    {
        $this->canAssignEnRuta = true;
        $this->capacityMessage = '';

        if ($this->selectedEnvio) {
            // Reload with fresh relationships to avoid stale data
            $freshEnvio = \App\Models\Envio::with(['vehiculo', 'paquete'])->find($this->selectedEnvio->id);

            if ($freshEnvio && $freshEnvio->vehiculo) {
                $result = $freshEnvio->vehiculo->canAccommodate($freshEnvio->paquete, $freshEnvio->id);
                if ($result !== true) {
                    $this->canAssignEnRuta = false;
                    $this->capacityMessage = $result;
                }
            }
        }
    }

    public function saveStatus()
    {
        $this->validate([
            'newStatusId' => 'required|exists:estado_envios,id',
            'comment' => 'required|string|max:255', // Required as per SQL error
            'photo' => 'nullable|image|max:10240',
        ]);

        $newStatus = \App\Models\EstadoEnvio::find($this->newStatusId);

        if ($newStatus->slug === 'entregado' && !$this->photo) {
            $this->addError('photo', 'La foto es obligatoria para marcar como entregado.');
            return;
        }

        // Validación de capacidad del vehículo si el estado es 'en-ruta'
        if ($newStatus->slug === 'en-ruta') {
            $envioForCheck = \App\Models\Envio::with(['vehiculo', 'paquete'])->find($this->selectedEnvio->id);
            $vehiculo = $envioForCheck->vehiculo;

            if ($vehiculo) {
                $result = $vehiculo->canAccommodate($envioForCheck->paquete, $envioForCheck->id);
                if ($result !== true) {
                    $this->addError('newStatusId', $result);
                    return;
                }
            }
        }

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('comprobantes', 'public');
        }

        $envio = \App\Models\Envio::find($this->selectedEnvio->id);
        $envio->update([
            'estado_envio_id' => $this->newStatusId,
        ]);

        \App\Models\HistorialEnvio::create([
            'envio_id' => $envio->id,
            'estado_envio_id' => $this->newStatusId,
            'comentario' => $this->comment,
            'foto_url' => $photoPath,
        ]);

        $this->showModal = false;
        $this->loadEnvios();

        // Update selected envio reference
        if ($this->selectedEnvio) {
            $this->selectedEnvio = $this->envios->firstWhere('id', $this->selectedEnvio->id);
        }

        $this->dispatch('showToast', ['message' => 'Estado actualizado correctamente', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.repartidor.route')
            ->layout('layout.base-drawer');
    }
}
