<?php

namespace App\Livewire;

use Livewire\Component;

class LoginForm extends Component
{
    // Este componente solo renderiza la vista
    // La lógica de login está en LoginController@login
    
    public function render()
    {
        return view('livewire.login-form');
    }
}
