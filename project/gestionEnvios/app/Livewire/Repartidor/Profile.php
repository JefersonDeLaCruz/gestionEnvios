<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;
use Illuminate\Validation\Rule;

class Profile extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;

    // Password change properties
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Modal state
    public $showEditModal = false;
    public $activeTab = 'personal'; // personal, security, preferences

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->nombre . ' ' . $user->apellido;
        $this->email = $user->email;
        $this->phone = $user->telefono;
        $this->address = $user->direccion;
    }

    public function updateProfile()
    {
        // 1. Sanitize and format phone number if provided
        if ($this->phone) {
            $rawTelefono = preg_replace('/\D/', '', $this->phone);

            // Format phone: 8 digits -> 0000-0000
            if (strlen($rawTelefono) == 8) {
                $this->phone = preg_replace('/^(\d{4})(\d{4})$/', '$1-$2', $rawTelefono);
            } else {
                $this->phone = $rawTelefono; // Leave raw if invalid length, validation will catch it
            }
        }

        // 2. Validate
        $this->validate([
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'phone' => ['nullable', 'string', 'regex:/^\d{4}-\d{4}$/', Rule::unique('users', 'telefono')->ignore(auth()->id())],
            'address' => 'nullable|string|max:255',
        ], [
            'phone.regex' => 'El teléfono debe tener 8 dígitos (ej: 7777-7777).',
            'phone.unique' => 'Este número de teléfono ya está registrado.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ]);

        $user = auth()->user();
        $user->email = $this->email;
        $user->telefono = $this->phone;
        $user->direccion = $this->address;
        $user->save();

        $this->showEditModal = false;
        session()->flash('message', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = bcrypt($this->new_password);
        $user->save();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showEditModal = false;
        // You might want to add a success notification here
    }

    public function render()
    {
        return view('livewire.repartidor.profile', [
            'user' => auth()->user()
        ])->layout('layout.base-drawer');
    }
}
