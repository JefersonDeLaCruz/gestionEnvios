<?php

namespace App\Livewire\Admin;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Clients extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;

    // Client form fields
    public $clientId;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $direccion;
    public $dui;
    public $nit;
    // public $latitud; // Optional, keeping if needed but focusing on main fields first
    // public $longitud; // Optional

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('clientes', 'email')->ignore($this->clientId)],
            'telefono' => ['required', 'string', 'regex:/^\d{4}-\d{4}$/', Rule::unique('clientes', 'telefono')->ignore($this->clientId)],
            'direccion' => 'required|string|max:255',
            'dui' => ['nullable', 'string', 'regex:/^\d{8}-\d{1}$/', Rule::unique('clientes', 'dui')->ignore($this->clientId)],
            'nit' => ['nullable', 'string', 'regex:/^\d{4}-\d{6}-\d{3}-\d{1}$/', Rule::unique('clientes', 'nit')->ignore($this->clientId)],
        ];
    }

    protected $validationAttributes = [
        'nombre' => 'nombre',
        'apellido' => 'apellido',
        'email' => 'correo electrónico',
        'telefono' => 'teléfono',
        'direccion' => 'dirección',
        'dui' => 'DUI',
        'nit' => 'NIT',
    ];

    protected $messages = [
        'telefono.regex' => 'El teléfono debe tener 8 dígitos (ej: 7777-7777).',
        'dui.regex' => 'El DUI debe tener el formato 00000000-0.',
        'nit.regex' => 'El NIT debe tener el formato 0000-000000-000-0.',
        'email.unique' => 'Este correo electrónico ya está registrado.',
        'telefono.unique' => 'Este número de teléfono ya está registrado.',
        'dui.unique' => 'Este número de DUI ya está registrado.',
        'nit.unique' => 'Este número de NIT ya está registrado.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($clientId)
    {
        $this->resetForm();
        $client = Cliente::findOrFail($clientId);

        $this->clientId = $client->id;
        $this->nombre = $client->nombre;
        $this->apellido = $client->apellido;
        $this->email = $client->email;
        $this->telefono = $client->telefono;
        $this->direccion = $client->direccion;
        $this->dui = $client->dui;
        $this->nit = $client->nit;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->clientId = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->email = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->dui = '';
        $this->nit = '';
    }

    public function save()
    {
        // 1. Sanitize inputs (remove everything except digits)
        $rawTelefono = preg_replace('/\D/', '', $this->telefono);
        $rawDui = preg_replace('/\D/', '', $this->dui);
        $rawNit = preg_replace('/\D/', '', $this->nit);

        // 2. Format values (if they have correct length, apply hyphens)
        // Phone: 8 digits -> 0000-0000
        if (strlen($rawTelefono) == 8) {
            $this->telefono = preg_replace('/^(\d{4})(\d{4})$/', '$1-$2', $rawTelefono);
        } else {
            $this->telefono = $rawTelefono; // Leave raw if invalid length, validation will catch it
        }

        // DUI: 9 digits -> 00000000-0
        if (strlen($rawDui) == 9) {
            $this->dui = preg_replace('/^(\d{8})(\d{1})$/', '$1-$2', $rawDui);
        } else {
            $this->dui = $rawDui;
        }

        // NIT: 14 digits -> 0000-000000-000-0
        if (strlen($rawNit) == 14) {
            $this->nit = preg_replace('/^(\d{4})(\d{6})(\d{3})(\d{1})$/', '$1-$2-$3-$4', $rawNit);
        } else {
            $this->nit = $rawNit;
        }

        // 3. Validate (rules expect hyphenated format)
        $this->validate();

        DB::beginTransaction();

        try {
            if ($this->editMode) {
                $client = Cliente::findOrFail($this->clientId);
                $client->update([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'email' => $this->email,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion,
                    'dui' => $this->dui,
                    'nit' => $this->nit,
                ]);

                session()->flash('message', 'Cliente actualizado exitosamente.');
            } else {
                Cliente::create([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'email' => $this->email,
                    'telefono' => $this->telefono,
                    'direccion' => $this->direccion,
                    'dui' => $this->dui,
                    'nit' => $this->nit,
                ]);

                session()->flash('message', 'Cliente creado exitosamente.');
            }

            DB::commit();
            $this->closeModal();
        } catch (QueryException $e) {
            DB::rollBack();
            $errorCode = $e->errorInfo[1] ?? null;
            if ($errorCode == 1062) {
                session()->flash('error', 'Ya existe un cliente con ese email o documento.');
            } else {
                session()->flash('error', 'Ocurrió un error al guardar el cliente.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ocurrió un error inesperado.');
        }
    }

    public function confirmDelete($clientId)
    {
        $this->clientId = $clientId;
        $this->showDeleteModal = true;
    }

    public function deleteClient()
    {
        try {
            $client = Cliente::findOrFail($this->clientId);
            $client->delete();

            $this->showDeleteModal = false;
            $this->clientId = null;
            session()->flash('message', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar el cliente.');
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->clientId = null;
    }

    public function render()
    {
        $query = Cliente::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('telefono', 'like', '%' . $this->search . '%')
                    ->orWhere('dui', 'like', '%' . $this->search . '%')
                    ->orWhere('nit', 'like', '%' . $this->search . '%');
            });
        }

        $clients = $query->latest()->paginate(10);
        $totalClients = Cliente::count();

        return view('livewire.admin.clients', [
            'clients' => $clients,
            'totalClients' => $totalClients,
        ])->layout('layout.base-drawer');
    }
}
