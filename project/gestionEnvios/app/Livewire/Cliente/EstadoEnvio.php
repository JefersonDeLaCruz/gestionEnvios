<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Envio;

class EstadoEnvio extends Component
{
    public $codigoPaquete = '';
    public $paquete = null;
    public $envio = null;
    public $historial = [];

    // Image modal properties
    public $selectedImageUrl = null;
    public $showImageModal = false;
    public $busquedaRealizada = false;
    public $noEncontrado = false;

    public function buscarPaquete()
    {
        $this->validate([
            'codigoPaquete' => 'required|string|min:3'
        ], [
            'codigoPaquete.required' => 'Por favor ingresa un código de paquete',
            'codigoPaquete.min' => 'El código debe tener al menos 3 caracteres'
        ]);

        $this->busquedaRealizada = true;
        $this->noEncontrado = false;

        // Buscar el paquete con sus relaciones
        $this->paquete = Paquete::where('codigo', $this->codigoPaquete)
            ->first();

        if (!$this->paquete) {
            $this->noEncontrado = true;
            $this->envio = null;
            $this->historial = [];
            return;
        }

        // Obtener el envío más reciente del paquete
        $this->envio = Envio::where('paquete_id', $this->paquete->id)
            ->with(['estadoEnvio', 'motorista', 'vehiculo'])
            ->latest()
            ->first();

        // Obtener el historial de estados del envío
        if ($this->envio) {
            $this->historial = $this->envio->historialEnvios()
                ->with('estadoEnvio')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function limpiarBusqueda()
    {
        $this->reset(['codigoPaquete', 'paquete', 'envio', 'historial', 'busquedaRealizada', 'noEncontrado']);
    }

    public function refreshData()
    {
        if ($this->busquedaRealizada && $this->paquete) {
            // Re-fetch envio and historial
            $this->envio = Envio::where('paquete_id', $this->paquete->id)
                ->with(['estadoEnvio', 'motorista', 'vehiculo'])
                ->latest()
                ->first();

            if ($this->envio) {
                $this->historial = $this->envio->historialEnvios()
                    ->with('estadoEnvio')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
    }

    public function viewImage($url)
    {
        \Log::info('viewImage called with URL: ' . $url);
        $this->selectedImageUrl = $url;
        $this->showImageModal = true;
        \Log::info('Modal state set - showImageModal: ' . ($this->showImageModal ? 'true' : 'false'));
    }

    public function closeImageModal()
    {
        $this->showImageModal = false;
        $this->selectedImageUrl = null;
    }

    public function render()
    {
        return view('livewire.cliente.estado-envio');
    }

    public function buscarDesdeEvento($codigo)
    {
        $this->reset(['paquete', 'envio', 'estado', 'errorMessage']);
        $this->trackingCode = trim($codigo);

        if (!$this->trackingCode) {
            $this->errorMessage = 'Por favor ingresa un código.';
            return;
        }

        $this->buscar();
    }

    public function buscar()
    {
        $codigo = $this->trackingCode;

        $paquete = Paquete::where('codigo', $codigo)->first();

        if (!$paquete) {
            $this->errorMessage = 'Código no encontrado.';
            return;
        }

        $envio = Envio::where('paquete_id', $paquete->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$envio) {
            $this->errorMessage = 'No se encontró información del envío.';
            $this->paquete = $paquete;
            return;
        }

        $estado = EstadoEnvioModel::find($envio->estado_envio_id);

        $this->paquete = $paquete;
        $this->envio = $envio;
        $this->estado = $estado;
    }

    public function refreshStatus()
    {
        if (!$this->envio)
            return;

        $envio = Envio::find($this->envio->id);

        if ($envio) {
            $this->envio = $envio;
            $this->estado = EstadoEnvioModel::find($envio->estado_envio_id);
        }
    }

    public function getActiveStepProperty()
    {
        if (!$this->estado)
            return -1;

        $slug = strtolower($this->estado->slug ?? $this->estado->nombre ?? '');

        return $this->stepMap[$slug] ?? -1;
    }
}
