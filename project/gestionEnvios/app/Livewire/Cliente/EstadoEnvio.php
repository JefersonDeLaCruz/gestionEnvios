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
}
