<?php

namespace App\Livewire;

use Livewire\Component;

class RegisterForm extends Component
{
    // Este componente solo renderiza la vista
    // La lógica de registro está en LoginController@register
    
    public function render()
    {
        return view('livewire.register-form');
    }
}
