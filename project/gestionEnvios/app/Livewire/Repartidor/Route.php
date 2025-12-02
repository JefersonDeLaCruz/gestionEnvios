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
        if ($user) {
            $this->envios = \App\Models\Envio::with(['paquete', 'estadoEnvio', 'historialEnvios', 'paquete.tipoEnvio'])
                ->where('motorista_id', $user->id)
                ->get();
        } else {
            $this->envios = collect();
        }
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

    public function updateStatus($envioId, $statusSlug)
    {
        $envio = \App\Models\Envio::find($envioId);
        $estado = \App\Models\EstadoEnvio::where('codigo', $statusSlug)->first(); // Assuming 'codigo' or similar field for slug

        if ($envio && $estado) {
            $envio->estado_envio_id = $estado->id;
            $envio->save();

            // Create history record
            \App\Models\HistorialEnvio::create([
                'envio_id' => $envio->id,
                'estado_envio_id' => $estado->id,
                'descripcion' => 'Estado actualizado por repartidor',
                'fecha_cambio' => now(),
            ]);

            $this->loadEnvios();

            // Update selected envio if it's the one being modified
            if ($this->selectedEnvio && $this->selectedEnvio->id == $envioId) {
                $this->selectedEnvio = $this->envios->firstWhere('id', $envioId);
            }

            $this->dispatch('showToast', ['message' => 'Estado actualizado correctamente', 'type' => 'success']);
        }
    }

    public function render()
    {
        return view('livewire.repartidor.route')
            ->layout('layout.base-drawer');
    }
}
