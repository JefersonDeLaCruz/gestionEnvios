<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Envio;
use App\Models\Cliente;
use App\Models\EnvioCliente;
use App\Models\User;

class Packages extends Component
{
    // Modal control
    public $showModal = false;
    public $currentStep = 1;

    // Pending shipments management
    public $pendingShipments = [];

    // Driver assignment modal
    public $showAssignModal = false;
    public $selectedEnvioId = null;
    public $availableDrivers = [];
    public $selectedDriverId = null;

    // Sender information
    public $sender_nombre = '';
    public $sender_apellido = '';
    public $sender_direccion = '';
    public $sender_telefono = '';
    public $sender_email = '';
    public $sender_dui = '';
    public $sender_nit = '';

    // Receiver information
    public $receiver_nombre = '';
    public $receiver_apellido = '';
    public $receiver_direccion = '';
    public $receiver_telefono = '';
    public $receiver_email = '';
    public $receiver_dui = '';
    public $receiver_nit = '';

    // Package information
    public $descripcion = '';
    public $peso = '';
    public $dimensiones = '';
    public $tipo_envio = 'estandar';
    public $fecha_estimada = '';

    public function openModal()
    {
        $this->showModal = true;
        $this->currentStep = 1;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->currentStep = 1;
        $this->reset([
            'sender_nombre',
            'sender_apellido',
            'sender_direccion',
            'sender_telefono',
            'sender_email',
            'sender_dui',
            'sender_nit',
            'receiver_nombre',
            'receiver_apellido',
            'receiver_direccion',
            'receiver_telefono',
            'receiver_email',
            'receiver_dui',
            'receiver_nit',
            'descripcion',
            'peso',
            'dimensiones',
            'tipo_envio',
            'fecha_estimada'
        ]);
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'sender_nombre' => 'required|string|max:255',
                'sender_apellido' => 'required|string|max:255',
                'sender_direccion' => 'required|string|max:500',
                'sender_telefono' => 'required|string|max:20',
                'sender_email' => 'nullable|email|max:255',
                'sender_dui' => 'nullable|string|max:20',
                'sender_nit' => 'nullable|string|max:20',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'receiver_nombre' => 'required|string|max:255',
                'receiver_apellido' => 'required|string|max:255',
                'receiver_direccion' => 'required|string|max:500',
                'receiver_telefono' => 'required|string|max:20',
                'receiver_email' => 'nullable|email|max:255',
                'receiver_dui' => 'nullable|string|max:20',
                'receiver_nit' => 'nullable|string|max:20',
            ]);
        }
    }

    public function save()
    {
        // Validate only package information (step 3)
        // Steps 1 and 2 are already validated when navigating
        $this->validate([
            'descripcion' => 'required|string|max:1000',
            'peso' => 'required|numeric|min:0.01',
            'dimensiones' => 'nullable|string|max:255',
            'tipo_envio' => 'required|in:estandar,express,overnight',
            'fecha_estimada' => 'required|date|after_or_equal:today',
        ]);

        // Find or create sender client
        // If a client with this email exists, reuse it; otherwise create new
        $sender = Cliente::firstOrCreate(
            ['email' => $this->sender_email ?: null], // Search by email (or null if empty)
            [
                'nombre' => $this->sender_nombre,
                'apellido' => $this->sender_apellido,
                'direccion' => $this->sender_direccion,
                'telefono' => $this->sender_telefono,
                'dui' => $this->sender_dui,
                'nit' => $this->sender_nit,
            ]
        );

        // Find or create receiver client
        $receiver = Cliente::firstOrCreate(
            ['email' => $this->receiver_email ?: null],
            [
                'nombre' => $this->receiver_nombre,
                'apellido' => $this->receiver_apellido,
                'direccion' => $this->receiver_direccion,
                'telefono' => $this->receiver_telefono,
                'dui' => $this->receiver_dui,
                'nit' => $this->receiver_nit,
            ]
        );

        // Create package with auto-generated code
        $paquete = Paquete::create([
            'codigo' => 'PKG' . str_pad(Paquete::count() + 1, 6, '0', STR_PAD_LEFT),
            'descripcion' => $this->descripcion,
            'peso' => $this->peso,
            'dimensiones' => $this->dimensiones,
            'tipo_envio' => $this->tipo_envio,
        ]);

        // Link sender to package
        EnvioCliente::create([
            'cliente_id' => $sender->id,
            'paquete_id' => $paquete->id,
            'tipo_cliente' => 'emisor',
        ]);

        // Link receiver to package
        EnvioCliente::create([
            'cliente_id' => $receiver->id,
            'paquete_id' => $paquete->id,
            'tipo_cliente' => 'receptor',
        ]);

        // Create shipment
        Envio::create([
            'paquete_id' => $paquete->id,
            'fecha_estimada' => $this->fecha_estimada,
            'estado_envio_id' => 1, // Default to pending
        ]);

        session()->flash('message', 'Envío creado exitosamente.');
        $this->closeModal();
    }

    public function mount()
    {
        $this->loadPendingShipments();
    }

    public function loadPendingShipments()
    {
        $this->pendingShipments = Envio::pendientes()
            ->with(['paquete.envioClientes.cliente', 'estadoEnvio'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openAssignModal($envioId)
    {
        $this->selectedEnvioId = $envioId;

        // Get users with 'repartidor' role who have an active vehicle
        $this->availableDrivers = User::role('repartidor')
            ->whereHas('vehiculos', function ($query) {
                $query->where('motorista_vehiculo.activo', true)
                    ->where('vehiculos.disponible', true);
            })
            ->with([
                'vehiculos' => function ($query) {
                    $query->where('motorista_vehiculo.activo', true);
                }
            ])
            ->get();

        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->selectedEnvioId = null;
        $this->selectedDriverId = null;
        $this->availableDrivers = [];
    }

    public function assignDriver()
    {
        $this->validate([
            'selectedDriverId' => 'required|exists:users,id',
        ]);

        $envio = Envio::findOrFail($this->selectedEnvioId);
        $driver = User::findOrFail($this->selectedDriverId);
        $vehicle = $driver->vehiculoActivo();

        if (!$vehicle) {
            session()->flash('error', 'El repartidor seleccionado no tiene un vehículo asignado.');
            return;
        }

        // Assign driver and vehicle to shipment
        $envio->update([
            'motorista_id' => $driver->id,
            'vehiculo_id' => $vehicle->id,
        ]);

        session()->flash('message', 'Repartidor asignado exitosamente.');
        $this->closeAssignModal();
        $this->loadPendingShipments();
    }

    public function render()
    {
        return view('livewire.admin.packages')
            ->layout('layout.base-drawer');
    }
}
