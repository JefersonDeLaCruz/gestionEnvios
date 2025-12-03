<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

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
        $this->validate([
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->email = $this->email;
        $user->telefono = $this->phone;
        $user->direccion = $this->address;
        $user->save();

        $this->showEditModal = false;
        // You might want to add a success notification here
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
