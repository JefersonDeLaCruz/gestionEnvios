<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

class Route extends Component
{
    public $envios;
    public $selectedEnvio = null;

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
        // Dispatch event for map update if needed
        $this->dispatch('envioSelected', [
            'lat' => $this->selectedEnvio->paquete->latitud,
            'lng' => $this->selectedEnvio->paquete->longitud,
            'address' => $this->selectedEnvio->paquete->direccion ?? 'Ubicación del paquete' // Assuming address might be in description or separate field, using fallback
        ]);
    }

    use \Livewire\WithFileUploads;

    public $showModal = false;
    public $newStatusId;
    public $comment;
    public $photo;

    public function openModal($envioId, $statusSlug)
    {
        $this->selectedEnvio = $this->envios->firstWhere('id', $envioId);
        $estado = \App\Models\EstadoEnvio::where('slug', $statusSlug)->first();

        if ($this->selectedEnvio && $estado) {
            $this->newStatusId = $estado->id;
            $this->comment = '';
            $this->photo = null;
            $this->showModal = true;
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
