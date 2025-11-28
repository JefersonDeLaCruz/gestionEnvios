<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginForm extends Component
{
    public $email = "";
    public $password = "";

    public function login()
    {
        
    }


    public function render()
    {
        return view('livewire.login-form');
    }


    public function irARegistro()
{
    $this->dispatch('open-register-modal');
}

}
