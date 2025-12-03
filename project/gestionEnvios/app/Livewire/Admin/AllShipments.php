<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Envio;
use App\Models\EstadoEnvio;
use App\Models\Paquete;
use App\Models\Cliente;
use App\Models\EnvioCliente;
use App\Models\TipoEnvio;
use App\Models\User;
use App\Mail\PackageCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AllShipments extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // Modal control
    public $showModal = false;
    public $currentStep = 1;
    public $isEditing = false;
    public $editingShipmentId = null;

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
    public $tiposEnvio = [];

    // Email notification option
    public $send_email_notification = true;

    // Driver assignment modal
    public $showAssignModal = false;
    public $selectedEnvioId = null;
    public $availableDrivers = [];
    public $selectedDriverId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->tiposEnvio = TipoEnvio::all();
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

    // Modal Details Logic
    public $showDetailsModal = false;
    public $selectedShipment = null;

    public function openDetailsModal($shipmentId)
    {
        $this->selectedShipment = Envio::with([
            'paquete',
            'paquete.envioClientes.cliente',
            'estadoEnvio',
            'motorista',
            'vehiculo',
            'historialEnvios.estadoEnvio'
        ])->findOrFail($shipmentId);

        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedShipment = null;
    }

    // CRUD Logic

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->currentStep = 1;
        $this->isEditing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'currentStep',
            'isEditing',
            'editingShipmentId',
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
            'fecha_estimada',
            'costo_calculado',
            'volumen_m3',
            'send_email_notification'
        ]);
        $this->currentStep = 1;
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
        $this->validate([
            'descripcion' => 'required|string|max:1000',
            'peso' => 'required|numeric|min:0.01',
            'dimensiones' => 'nullable|string|max:255',
            'tipo_envio_id' => 'required|exists:tipos_envio,id',
            'fecha_estimada' => 'required|date',
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

        if ($this->isEditing) {
            $envio = Envio::find($this->editingShipmentId);
            $paquete = $envio->paquete;

            $paquete->update([
                'descripcion' => $this->descripcion,
                'peso' => $this->peso,
                'dimensiones' => $this->dimensiones,
                'tipo_envio_id' => $this->tipo_envio_id,
                'latitud' => $this->receiver_lat,
                'longitud' => $this->receiver_lng,
            ]);

            $envio->update([
                'fecha_estimada' => $this->fecha_estimada,
                'costo' => $this->costo_calculado,
            ]);

            // Update clients logic if needed (relationships are already set, but if client changed completely it's complex)
            // For now assuming we just update the client info of the linked clients as done above.
            // If we wanted to CHANGE the client to a different one, we'd need to update EnvioCliente.
            // But the UI updates the fields of the CURRENT selected client or creates a new one.
            // If sender_id changed, we should update the link.

            // Update sender link
            $envioClienteSender = EnvioCliente::where('paquete_id', $paquete->id)->where('tipo_cliente', 'emisor')->first();
            if ($envioClienteSender) {
                $envioClienteSender->update(['cliente_id' => $sender->id]);
            } else {
                EnvioCliente::create(['cliente_id' => $sender->id, 'paquete_id' => $paquete->id, 'tipo_cliente' => 'emisor']);
            }

            // Update receiver link
            $envioClienteReceiver = EnvioCliente::where('paquete_id', $paquete->id)->where('tipo_cliente', 'receptor')->first();
            if ($envioClienteReceiver) {
                $envioClienteReceiver->update(['cliente_id' => $receiver->id]);
            } else {
                EnvioCliente::create(['cliente_id' => $receiver->id, 'paquete_id' => $paquete->id, 'tipo_cliente' => 'receptor']);
            }


            session()->flash('message', 'Envío actualizado exitosamente.');
        } else {
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

            // Send email notifications if enabled
            if ($this->send_email_notification) {
                try {
                    if ($sender->email) {
                        Mail::to($sender->email)->send(new PackageCreatedMail($paquete, $sender, 'emisor', $receiver));
                    }
                    if ($receiver->email) {
                        Mail::to($receiver->email)->send(new PackageCreatedMail($paquete, $receiver, 'receptor', $sender));
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send package notification emails', ['error' => $e->getMessage()]);
                }
            }

            session()->flash('message', 'Envío creado exitosamente.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->editingShipmentId = $id;

        $envio = Envio::with(['paquete.envioClientes.cliente', 'paquete.tipoEnvio'])->findOrFail($id);
        $paquete = $envio->paquete;
        $sender = $paquete->envioClientes->where('tipo_cliente', 'emisor')->first()?->cliente;
        $receiver = $paquete->envioClientes->where('tipo_cliente', 'receptor')->first()?->cliente;

        // Load Sender
        if ($sender) {
            $this->sender_id = $sender->id;
            $this->sender_nombre = $sender->nombre;
            $this->sender_apellido = $sender->apellido;
            $this->sender_direccion = $sender->direccion;
            $this->sender_telefono = $sender->telefono;
            $this->sender_email = $sender->email;
            $this->sender_dui = $sender->dui;
            $this->sender_nit = $sender->nit;
            $this->sender_lat = $sender->latitud;
            $this->sender_lng = $sender->longitud;
        }

        // Load Receiver
        if ($receiver) {
            $this->receiver_id = $receiver->id;
            $this->receiver_nombre = $receiver->nombre;
            $this->receiver_apellido = $receiver->apellido;
            $this->receiver_direccion = $receiver->direccion;
            $this->receiver_telefono = $receiver->telefono;
            $this->receiver_email = $receiver->email;
            $this->receiver_dui = $receiver->dui;
            $this->receiver_nit = $receiver->nit;
            $this->receiver_lat = $paquete->latitud; // Use package destination as receiver lat/lng
            $this->receiver_lng = $paquete->longitud;
        }

        // Load Package
        $this->descripcion = $paquete->descripcion;
        $this->peso = $paquete->peso;
        $this->dimensiones = $paquete->dimensiones;
        $this->tipo_envio_id = $paquete->tipo_envio_id;
        $this->fecha_estimada = \Carbon\Carbon::parse($envio->fecha_estimada)->format('Y-m-d');
        $this->costo_calculado = $envio->costo;

        $this->calculateVolume();
        $this->showModal = true;
    }

    public function delete($id)
    {
        $envio = Envio::findOrFail($id);
        $paquete = $envio->paquete;

        // Delete relationships
        $envio->delete();
        $paquete->envioClientes()->delete();
        $paquete->delete();

        session()->flash('message', 'Envío eliminado exitosamente.');
    }

    // Driver Assignment Logic

    public function openAssignModal($envioId)
    {
        $this->selectedEnvioId = $envioId;
        $envio = Envio::find($envioId);
        $this->selectedDriverId = $envio->motorista_id; // Pre-select current driver if any

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

        // If current driver is not in available list (e.g. busy or vehicle unavailable but currently assigned), add them to list so we can see them
        if ($this->selectedDriverId) {
            $currentDriver = User::find($this->selectedDriverId);
            if ($currentDriver && !$this->availableDrivers->contains('id', $this->selectedDriverId)) {
                $this->availableDrivers->push($currentDriver);
            }
        }

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
        
        // If assigning a new driver, check vehicle. If keeping same driver, just update (redundant but safe)
        if ($envio->motorista_id !== $driver->id) {
             $vehicle = $driver->vehiculoActivo();

            if (!$vehicle) {
                session()->flash('error', 'El repartidor seleccionado no tiene un vehículo asignado.');
                return;
            }
            
            $envio->update([
                'motorista_id' => $driver->id,
                'vehiculo_id' => $vehicle->id,
                'estado_envio_id' => 2, // Set to 'En Transito' or similar if appropriate, or keep current status. Let's keep current status or set to Pending/In Transit depending on logic.
                // Actually, usually assigning a driver moves it to "In Transit" or ready. 
                // But if we are just changing driver, maybe we shouldn't change status blindly.
                // For now, let's just update the driver and vehicle.
            ]);
        }

        session()->flash('message', 'Repartidor actualizado exitosamente.');
        $this->closeAssignModal();
    }
}
