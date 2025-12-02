<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Paquete;
use App\Models\Envio;
use App\Models\Cliente;
use App\Models\EnvioCliente;
use App\Models\User;
use App\Models\EstadoEnvio;
use App\Models\TipoEnvio;

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

    // Filters
    public $search = '';
    public $status = '';
    public $statuses = [];
    public $tiposEnvio = [];
    public $date = '';

    // Sender information
    public $sender_search = '';
    public $sender_suggestions = [];
    public $sender_id = null;
    public $sender_nombre = '';
    public $sender_apellido = '';
    public $sender_direccion = '';
    public $sender_telefono = '';
    public $sender_email = '';
    public $sender_dui = '';
    public $sender_nit = '';
    public $sender_lat = null;
    public $sender_lng = null;

    // Receiver information
    public $receiver_search = '';
    public $receiver_suggestions = [];
    public $receiver_id = null;
    public $receiver_nombre = '';
    public $receiver_apellido = '';
    public $receiver_direccion = '';
    public $receiver_telefono = '';
    public $receiver_email = '';
    public $receiver_dui = '';
    public $receiver_nit = '';
    public $receiver_lat = null;
    public $receiver_lng = null;

    // Package information
    public $descripcion = '';
    public $peso = '';
    public $dimensiones = '';
    public $tipo_envio_id = null;
    public $fecha_estimada = '';
    public $costo_calculado = 0;
    public $volumen_m3 = 0;

    public function updatedSearch()
    {
        $this->loadPendingShipments();
    }

    public function updatedStatus()
    {
        $this->loadPendingShipments();
    }

    public function updatedDate()
    {
        $this->loadPendingShipments();
    }

    public function updatedSenderSearch()
    {
        if (strlen($this->sender_search) < 2) {
            $this->sender_suggestions = [];
            return;
        }

        $this->sender_suggestions = Cliente::where('nombre', 'like', '%' . $this->sender_search . '%')
            ->orWhere('apellido', 'like', '%' . $this->sender_search . '%')
            ->orWhere('telefono', 'like', '%' . $this->sender_search . '%')
            ->orWhere('email', 'like', '%' . $this->sender_search . '%')
            ->orWhere('dui', 'like', '%' . $this->sender_search . '%')
            ->orWhere('nit', 'like', '%' . $this->sender_search . '%')
            ->take(5)
            ->get();
    }

    public function selectSender($id)
    {
        $client = Cliente::find($id);
        if ($client) {
            $this->sender_id = $client->id;
            $this->sender_nombre = $client->nombre;
            $this->sender_apellido = $client->apellido;
            $this->sender_direccion = $client->direccion;
            $this->sender_telefono = $client->telefono;
            $this->sender_email = $client->email;
            $this->sender_dui = $client->dui;
            $this->sender_nit = $client->nit;
            $this->sender_lat = $client->latitud;
            $this->sender_lng = $client->longitud;
            $this->sender_search = '';
            $this->sender_suggestions = [];
        }
    }

    public function updatedReceiverSearch()
    {
        if (strlen($this->receiver_search) < 2) {
            $this->receiver_suggestions = [];
            return;
        }

        $this->receiver_suggestions = Cliente::where('nombre', 'like', '%' . $this->receiver_search . '%')
            ->orWhere('apellido', 'like', '%' . $this->receiver_search . '%')
            ->orWhere('telefono', 'like', '%' . $this->receiver_search . '%')
            ->orWhere('email', 'like', '%' . $this->receiver_search . '%')
            ->orWhere('dui', 'like', '%' . $this->receiver_search . '%')
            ->orWhere('nit', 'like', '%' . $this->receiver_search . '%')
            ->take(5)
            ->get();
    }

    public function selectReceiver($id)
    {
        $client = Cliente::find($id);
        if ($client) {
            $this->receiver_id = $client->id;
            $this->receiver_nombre = $client->nombre;
            $this->receiver_apellido = $client->apellido;
            $this->receiver_direccion = $client->direccion;
            $this->receiver_telefono = $client->telefono;
            $this->receiver_email = $client->email;
            $this->receiver_dui = $client->dui;
            $this->receiver_nit = $client->nit;
            $this->receiver_lat = $client->latitud;
            $this->receiver_lng = $client->longitud;
            $this->receiver_search = '';
            $this->receiver_suggestions = [];
        }
    }

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
            'sender_id',
            'sender_search',
            'sender_suggestions',
            'sender_nombre',
            'sender_apellido',
            'sender_direccion',
            'sender_telefono',
            'sender_email',
            'sender_dui',
            'sender_nit',
            'sender_lat',
            'sender_lng',
            'receiver_id',
            'receiver_search',
            'receiver_suggestions',
            'receiver_nombre',
            'receiver_apellido',
            'receiver_direccion',
            'receiver_telefono',
            'receiver_email',
            'receiver_dui',
            'receiver_nit',
            'receiver_lat',
            'receiver_lng',
            'descripcion',
            'peso',
            'dimensiones',
            'tipo_envio_id',
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
                'sender_lat' => 'nullable|numeric|between:-90,90',
                'sender_lng' => 'nullable|numeric|between:-180,180',
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

    public function updatedPeso()
    {
        $this->calculateCost();
    }

    public function updatedDimensiones()
    {
        $this->calculateVolume();
        $this->calculateCost();
    }

    public function updatedTipoEnvioId()
    {
        $this->calculateCost();
    }

    private function calculateVolume()
    {
        if (empty($this->dimensiones)) {
            $this->volumen_m3 = 0;
            return;
        }

        // Parse dimensions (e.g., "30x20x15" in cm)
        $parts = preg_split('/[xX*×]/', $this->dimensiones);
        if (count($parts) === 3) {
            $largo = floatval(trim($parts[0]));
            $ancho = floatval(trim($parts[1]));
            $alto = floatval(trim($parts[2]));

            // Convert cm³ to m³
            $this->volumen_m3 = ($largo * $ancho * $alto) / 1000000;
        } else {
            $this->volumen_m3 = 0;
        }
    }

    public function calculateCost()
    {
        if (!$this->tipo_envio_id || !$this->peso) {
            $this->costo_calculado = 0;
            return;
        }

        $tipoEnvio = TipoEnvio::find($this->tipo_envio_id);
        if (!$tipoEnvio) {
            $this->costo_calculado = 0;
            return;
        }

        $this->calculateVolume();

        // Calculate cost: base + (peso * tarifa_kg) + (volumen * tarifa_m3)
        $costoBase = $tipoEnvio->tarifa_base ?? 0;
        $costoPeso = ($this->peso ?? 0) * ($tipoEnvio->tarifa_por_kg ?? 0);
        $costoVolumen = $this->volumen_m3 * ($tipoEnvio->tarifa_por_m3 ?? 0);

        $this->costo_calculado = $costoBase + $costoPeso + $costoVolumen;
    }

    public function save()
    {
        // Validate only package information (step 3)
        // Steps 1 and 2 are already validated when navigating
        $this->validate([
            'descripcion' => 'required|string|max:1000',
            'peso' => 'required|numeric|min:0.01',
            'dimensiones' => 'nullable|string|max:255',
            'tipo_envio_id' => 'required|exists:tipos_envio,id',
            'fecha_estimada' => 'required|date|after_or_equal:' . \Carbon\Carbon::now()->setTimezone('America/El_Salvador')->format('Y-m-d'),
            'receiver_lat' => 'required|numeric|between:-90,90',
            'receiver_lng' => 'required|numeric|between:-180,180',
        ]);

        // Find or create sender client
        if ($this->sender_id) {
            $sender = Cliente::find($this->sender_id);
            $sender->update([
                'nombre' => $this->sender_nombre,
                'apellido' => $this->sender_apellido,
                'direccion' => $this->sender_direccion,
                'telefono' => $this->sender_telefono,
                'dui' => $this->sender_dui,
                'nit' => $this->sender_nit,
                'email' => $this->sender_email,
            ]);
        } else {
            $sender = Cliente::firstOrCreate(
                ['email' => $this->sender_email ?: null],
                [
                    'nombre' => $this->sender_nombre,
                    'apellido' => $this->sender_apellido,
                    'direccion' => $this->sender_direccion,
                    'telefono' => $this->sender_telefono,
                    'dui' => $this->sender_dui,
                    'nit' => $this->sender_nit,
                ]
            );
        }

        // Find or create receiver client
        if ($this->receiver_id) {
            $receiver = Cliente::find($this->receiver_id);
            $receiver->update([
                'nombre' => $this->receiver_nombre,
                'apellido' => $this->receiver_apellido,
                'direccion' => $this->receiver_direccion,
                'telefono' => $this->receiver_telefono,
                'dui' => $this->receiver_dui,
                'nit' => $this->receiver_nit,
                'email' => $this->receiver_email,
            ]);
        } else {
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
        }

        // Create package with auto-generated code
        $paquete = Paquete::create([
            'codigo' => 'PKG' . str_pad(Paquete::count() + 1, 6, '0', STR_PAD_LEFT),
            'descripcion' => $this->descripcion,
            'peso' => $this->peso,
            'dimensiones' => $this->dimensiones,
            'tipo_envio_id' => $this->tipo_envio_id,
            'latitud' => $this->receiver_lat,
            'longitud' => $this->receiver_lng,
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
            'costo' => $this->costo_calculado,
        ]);

        session()->flash('message', 'Envío creado exitosamente.');
        $this->loadPendingShipments();
        $this->closeModal();
    }

    public function mount()
    {
        $this->statuses = EstadoEnvio::all();
        $this->tiposEnvio = TipoEnvio::all();
        $this->loadPendingShipments();
    }

    public function loadPendingShipments()
    {
        $query = Envio::query()
            ->with(['paquete.envioClientes.cliente', 'estadoEnvio'])
            ->whereNull('motorista_id'); // Only show unassigned shipments

        if ($this->search) {
            $query->whereHas('paquete', function ($q) {
                $q->where('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('peso', 'like', '%' . $this->search . '%')
                    ->orWhere('dimensiones', 'like', '%' . $this->search . '%')
                    ->orWhereHas('envioClientes.cliente', function ($qc) {
                        $qc->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%')
                            ->orWhere('dui', 'like', '%' . $this->search . '%')
                            ->orWhere('nit', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->status && $this->status !== 'Todos') {
            $query->whereHas('estadoEnvio', function ($q) {
                $q->where('nombre', $this->status);
            });
        }

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }

        $this->pendingShipments = $query->orderBy('created_at', 'desc')->get();
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
