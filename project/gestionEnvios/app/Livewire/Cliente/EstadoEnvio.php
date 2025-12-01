<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Envio;
use App\Models\EstadoEnvio as EstadoEnvioModel;

class EstadoEnvio extends Component
{
    public $trackingCode = '';
    public $paquete = null;
    public $envio = null;
    public $estado = null;
    public $errorMessage = null;

    protected $stepMap = [
        'pendiente' => 0,
        'enviado'   => 1,
        'entregado' => 2,
    ];

    protected $listeners = [
        'buscarCodigo' => 'buscarDesdeEvento',
        'buscarDesdeEvento' => 'buscarDesdeEvento', // opcional, en caso uses ese nombre

    ];

    public function render()
    {
        return view('livewire.cliente.estado-envio');
    }

    public function buscarDesdeEvento($codigo)
    {
        $this->reset(['paquete', 'envio', 'estado', 'errorMessage']);
        $this->trackingCode = trim($codigo);

        if (! $this->trackingCode) {
            $this->errorMessage = 'Por favor ingresa un código.';
            return;
        }

        $this->buscar();
    }

    public function buscar()
    {
        $codigo = $this->trackingCode;

        $paquete = Paquete::where('codigo', $codigo)->first();

        if (! $paquete) {
            $this->errorMessage = 'Código no encontrado.';
            return;
        }

        $envio = Envio::where('paquete_id', $paquete->id)
                      ->orderBy('created_at', 'desc')
                      ->first();

        if (! $envio) {
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
        if (! $this->envio) return;

        $envio = Envio::find($this->envio->id);

        if ($envio) {
            $this->envio = $envio;
            $this->estado = EstadoEnvioModel::find($envio->estado_envio_id);
        }
    }

    public function getActiveStepProperty()
    {
        if (! $this->estado) return -1;

        $slug = strtolower($this->estado->slug ?? $this->estado->nombre ?? '');

        return $this->stepMap[$slug] ?? -1;
    }
}
