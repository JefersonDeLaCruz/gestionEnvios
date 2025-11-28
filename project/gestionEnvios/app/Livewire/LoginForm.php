<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginForm extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended('/');
        }

        $this->addError('email', 'Estas credenciales no coinciden con nuestros registros.');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}
