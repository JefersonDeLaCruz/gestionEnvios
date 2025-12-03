<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\TipoVehiculo;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DriversVehicles extends Component
{
    // Collections
    public $drivers = [];
    public $vehicles = [];
    public $tiposVehiculo = [];

    // Modal visibility
    public $showDriverModal = false;
    public $showVehicleModal = false;
    public $showAssignmentModal = false;

    // Editing IDs
    public $editingDriverId = null;
    public $editingVehicleId = null;
    public $assigningDriverId = null;

    // Driver form fields
    public $driver_nombre = '';
    public $driver_apellido = '';
    public $driver_email = '';
    public $driver_telefono = '';
    public $driver_direccion = '';
    public $driver_password = '';

    // Vehicle form fields
    public $vehicle_tipo_vehiculo_id = '';
    public $vehicle_numero_placas = '';
    public $vehicle_marca = '';
    public $vehicle_modelo = '';
    public $vehicle_capacidad_kg = '';
    public $vehicle_capacidad_m3 = '';
    public $vehicle_disponible = true;

    // Assignment
    public $selectedVehicleId = null;
    public $availableVehicles = [];

    public function mount()
    {
        $this->loadDrivers();
        $this->loadVehicles();
        $this->loadTiposVehiculo();
    }

    public function loadDrivers()
    {
        $this->drivers = User::role('repartidor')
            ->where('estado', true) // Filtrar solo usuarios activos
            ->with([
                'vehiculos' => function ($query) {
                    $query->where('motorista_vehiculo.activo', true);
                }
            ])
            ->get();
    }

    public function loadVehicles()
    {
        $this->vehicles = Vehiculo::with([
            'tipoVehiculo',
            'motoristas' => function ($query) {
                $query->where('motorista_vehiculo.activo', true);
            }
        ])->get();
    }

    public function loadTiposVehiculo()
    {
        $this->tiposVehiculo = TipoVehiculo::all();
    }

    // Driver CRUD
    public function openDriverModal($driverId = null)
    {
        $this->resetDriverForm();
        $this->editingDriverId = $driverId;

        if ($driverId) {
            $driver = User::findOrFail($driverId);
            $this->driver_nombre = $driver->nombre;
            $this->driver_apellido = $driver->apellido;
            $this->driver_email = $driver->email;
            $this->driver_telefono = $driver->telefono;
            $this->driver_direccion = $driver->direccion;
        }

        $this->showDriverModal = true;
    }

    public function saveDriver()
    {
        $rules = [
            'driver_nombre' => 'required|string|max:255',
            'driver_apellido' => 'required|string|max:255',
            'driver_email' => 'required|email|max:255|unique:users,email,' . $this->editingDriverId,
            'driver_telefono' => 'required|string|max:20',
            'driver_direccion' => 'required|string|max:500',
        ];

        if (!$this->editingDriverId) {
            $rules['driver_password'] = 'required|string|min:8';
        }

        $this->validate($rules);

        $data = [
            'nombre' => $this->driver_nombre,
            'apellido' => $this->driver_apellido,
            'email' => $this->driver_email,
            'telefono' => $this->driver_telefono,
            'direccion' => $this->driver_direccion,
        ];

        if ($this->editingDriverId) {
            $driver = User::findOrFail($this->editingDriverId);
            $driver->update($data);
            session()->flash('message', 'Repartidor actualizado exitosamente.');
        } else {
            $data['password'] = Hash::make($this->driver_password);
            $data['estado'] = true;
            $driver = User::create($data);
            $driver->assignRole('repartidor');
            session()->flash('message', 'Repartidor creado exitosamente.');
        }

        $this->closeDriverModal();
        $this->loadDrivers();
    }

    public function deleteDriver($driverId)
    {
        $driver = User::findOrFail($driverId);

        // Unassign any vehicles first
        $driver->vehiculos()->detach();

        $driver->delete();
        session()->flash('message', 'Repartidor eliminado exitosamente.');
        $this->loadDrivers();
    }

    public function closeDriverModal()
    {
        $this->showDriverModal = false;
        $this->resetDriverForm();
    }

    private function resetDriverForm()
    {
        $this->editingDriverId = null;
        $this->driver_nombre = '';
        $this->driver_apellido = '';
        $this->driver_email = '';
        $this->driver_telefono = '';
        $this->driver_direccion = '';
        $this->driver_password = '';
        $this->resetErrorBag();
    }

    // Vehicle CRUD
    public function openVehicleModal($vehicleId = null)
    {
        $this->resetVehicleForm();
        $this->editingVehicleId = $vehicleId;

        if ($vehicleId) {
            $vehicle = Vehiculo::findOrFail($vehicleId);
            $this->vehicle_tipo_vehiculo_id = $vehicle->tipo_vehiculo_id;
            $this->vehicle_numero_placas = $vehicle->numero_placas;
            $this->vehicle_marca = $vehicle->marca;
            $this->vehicle_modelo = $vehicle->modelo;
            $this->vehicle_capacidad_kg = $vehicle->capacidad_kg;
            $this->vehicle_capacidad_m3 = $vehicle->capacidad_m3;
            $this->vehicle_disponible = $vehicle->disponible;
        }

        $this->showVehicleModal = true;
    }

    public function saveVehicle()
    {
        $this->validate([
            'vehicle_tipo_vehiculo_id' => 'required|exists:tipo_vehiculos,id',
            'vehicle_numero_placas' => 'required|string|max:20|unique:vehiculos,numero_placas,' . $this->editingVehicleId,
            'vehicle_marca' => 'required|string|max:255',
            'vehicle_modelo' => 'required|string|max:255',
            'vehicle_capacidad_kg' => 'required|numeric|min:0',
            'vehicle_capacidad_m3' => 'required|numeric|min:0',
        ]);

        $data = [
            'tipo_vehiculo_id' => $this->vehicle_tipo_vehiculo_id,
            'numero_placas' => $this->vehicle_numero_placas,
            'marca' => $this->vehicle_marca,
            'modelo' => $this->vehicle_modelo,
            'capacidad_kg' => $this->vehicle_capacidad_kg,
            'capacidad_m3' => $this->vehicle_capacidad_m3,
            'disponible' => $this->vehicle_disponible,
        ];

        if ($this->editingVehicleId) {
            Vehiculo::findOrFail($this->editingVehicleId)->update($data);
            session()->flash('message', 'Vehículo actualizado exitosamente.');
        } else {
            Vehiculo::create($data);
            session()->flash('message', 'Vehículo creado exitosamente.');
        }

        $this->closeVehicleModal();
        $this->loadVehicles();
    }

    public function deleteVehicle($vehicleId)
    {
        $vehicle = Vehiculo::findOrFail($vehicleId);

        // Unassign from any drivers first
        $vehicle->motoristas()->detach();

        $vehicle->delete();
        session()->flash('message', 'Vehículo eliminado exitosamente.');
        $this->loadVehicles();
    }

    public function closeVehicleModal()
    {
        $this->showVehicleModal = false;
        $this->resetVehicleForm();
    }

    private function resetVehicleForm()
    {
        $this->editingVehicleId = null;
        $this->vehicle_tipo_vehiculo_id = '';
        $this->vehicle_numero_placas = '';
        $this->vehicle_marca = '';
        $this->vehicle_modelo = '';
        $this->vehicle_capacidad_kg = '';
        $this->vehicle_capacidad_m3 = '';
        $this->vehicle_disponible = true;
        $this->resetErrorBag();
    }

    // Vehicle Assignment
    public function openAssignmentModal($driverId)
    {
        $this->assigningDriverId = $driverId;
        $this->selectedVehicleId = null;

        // Get vehicles that are available and not assigned to other drivers
        $this->availableVehicles = Vehiculo::where('disponible', true)
            ->whereDoesntHave('motoristas', function ($query) use ($driverId) {
                $query->where('motorista_vehiculo.activo', true)
                    ->where('users.id', '!=', $driverId);
            })
            ->get();

        $this->showAssignmentModal = true;
    }

    public function assignVehicle()
    {
        $this->validate([
            'selectedVehicleId' => 'required|exists:vehiculos,id',
        ]);

        $driver = User::findOrFail($this->assigningDriverId);

        // Unassign any current vehicle
        $driver->vehiculos()->updateExistingPivot(
            $driver->vehiculos()->pluck('vehiculos.id')->toArray(),
            ['activo' => false]
        );

        // Assign new vehicle
        $driver->vehiculos()->syncWithoutDetaching([
            $this->selectedVehicleId => [
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        session()->flash('message', 'Vehículo asignado exitosamente.');
        $this->closeAssignmentModal();
        $this->loadDrivers();
        $this->loadVehicles();
    }

    public function unassignVehicle($driverId)
    {
        $driver = User::findOrFail($driverId);
        $driver->vehiculos()->updateExistingPivot(
            $driver->vehiculos()->pluck('vehiculos.id')->toArray(),
            ['activo' => false]
        );

        session()->flash('message', 'Vehículo desasignado exitosamente.');
        $this->loadDrivers();
        $this->loadVehicles();
    }

    public function closeAssignmentModal()
    {
        $this->showAssignmentModal = false;
        $this->assigningDriverId = null;
        $this->selectedVehicleId = null;
        $this->availableVehicles = [];
    }

    public function render()
    {
        return view('livewire.admin.drivers-vehicles')->layout('layout.base-drawer');
    }
}
