<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;

    // User form fields
    public $userId;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $direccion;
    public $password;
    public $password_confirmation;
    public $estado = 1;
    public $role = 'usuario';

    protected $paginationTheme = 'daisyui';

    protected function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'estado' => 'required|boolean',
            'role' => 'required|in:usuario,repartidor,admin',
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($this->password) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    protected $validationAttributes = [
        'nombre' => 'nombre',
        'apellido' => 'apellido',
        'email' => 'correo electrónico',
        'telefono' => 'teléfono',
        'direccion' => 'dirección',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'estado' => 'estado',
        'role' => 'rol',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($userId)
    {
        $this->resetForm();
        $user = User::findOrFail($userId);

        $this->userId = $user->id;
        $this->nombre = $user->nombre;
        $this->apellido = $user->apellido;
        $this->email = $user->email;
        $this->telefono = $user->telefono;
        $this->direccion = $user->direccion;
        $this->estado = $user->estado;
        $this->role = $user->getRoleNames()->first() ?? 'usuario';

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
        $this->userId = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->email = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->estado = 1;
        $this->role = 'usuario';
    }

    //funcion para guardar nuevo usuario
    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'estado' => $this->estado,
            ]);

            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            // Sync the user's role
            $user->syncRoles([$this->role]);

            session()->flash('message', 'Usuario actualizado exitosamente.');
        } else {
            $user = User::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'password' => Hash::make($this->password),
                'estado' => $this->estado,
            ]);

            // Assign the selected role
            $user->assignRole($this->role);

            session()->flash('message', 'Usuario creado exitosamente.');
        }

        $this->closeModal();
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['estado' => !$user->estado]);

        $status = $user->estado ? 'activado' : 'dado de baja';
        session()->flash('message', "Usuario {$status} exitosamente.");
    }

    public function confirmDelete($userId)
    {
        $this->userId = $userId;
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userId);

        // Validar que el usuario no se esté eliminando a sí mismo
        if ($user->id === auth()->id()) {
            $this->showDeleteModal = false;
            $this->userId = null;
            session()->flash('error', 'No puedes eliminarte a ti mismo.');
            return;
        }

        $user->delete();

        $this->showDeleteModal = false;
        $this->userId = null;
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->userId = null;
    }

    public function render()
    {
        // Obtener todos los usuarios con cualquier rol
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('telefono', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== '') {
            $query->where('estado', $this->statusFilter);
        }

        $users = $query->latest()->paginate(10);
        $totalUsers = User::count();
        $activeUsers = User::where('estado', 1)->count();
        $inactiveUsers = User::where('estado', 0)->count();

        return view('livewire.admin.users', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
        ])->layout('layout.base-drawer');
    }
}
