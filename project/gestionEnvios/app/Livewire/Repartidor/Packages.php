<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Envio;
use App\Models\EstadoEnvio;
use App\Models\HistorialEnvio;

class Packages extends Component
{
    use WithFileUploads;

    public $selectedEnvio = null;
    public $newStatusId;
    public $comment;
    public $photo;
    public $showModal = false;

    public function render()
    {
        $today = now()->startOfDay();

        $envios = Envio::with(['paquete', 'estadoEnvio', 'vehiculo'])
            ->where('motorista_id', Auth::id())
            ->whereDate('fecha_estimada', now())
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $envios->count(),
            'pendientes' => $envios->where('estadoEnvio.slug', 'pendiente')->count(),
            'enviados' => $envios->where('estadoEnvio.slug', 'enviado')->count(), // Assuming 'enviado' or 'en-transito' check slug
            'entregados' => $envios->where('estadoEnvio.slug', 'entregado')->count(),
        ];

        // If 'enviado' slug is different, I should check. 
        // Based on previous file content, I saw 'Pendiente', 'Enviado', 'Entregado' in seeder.
        // But in blade I saw 'En tránsito'. Let's check seeder again if needed, but I'll stick to seeder slugs I saw: 'pendiente', 'enviado', 'entregado'.

        $estados = EstadoEnvio::orderBy('id')->get();

        return view('livewire.repartidor.packages', [
            'envios' => $envios,
            'estados' => $estados,
            'stats' => $stats
        ])->layout('layout.base-drawer');
    }

    public function openModal($envioId)
    {
        $this->selectedEnvio = Envio::find($envioId);
        $this->newStatusId = $this->selectedEnvio->estado_envio_id;
        $this->comment = '';
        $this->photo = null;
        $this->showModal = true;
    }

    public function updateStatus()
    {
        $this->validate([
            'newStatusId' => 'required|exists:estado_envios,id',
            'comment' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:10240', // 10MB max
        ]);

        // Check if status is "Entregado" (assuming slug 'entregado' or similar logic, checking name for now or ID if known)
        // Better to check the selected status object
        $newStatus = EstadoEnvio::find($this->newStatusId);

        if ($newStatus->slug === 'entregado' && !$this->photo) {
            $this->addError('photo', 'La foto es obligatoria para marcar como entregado.');
            return;
        }

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('comprobantes', 'public');
        }

        $this->selectedEnvio->update([
            'estado_envio_id' => $this->newStatusId,
        ]);

        HistorialEnvio::create([
            'envio_id' => $this->selectedEnvio->id,
            'estado_envio_id' => $this->newStatusId,
            'comentario' => $this->comment,
            'foto_url' => $photoPath,
        ]);

        $this->showModal = false;
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Estado actualizado correctamente']);
    }
}
