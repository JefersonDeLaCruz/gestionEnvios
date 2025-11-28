<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginForm extends Component
{
    public $email;
    public $password;

    public function login()
    {/* 
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = Auth::guard('web')->user();
        if ($user) {
            return redirect()->intended('/admin');
        }
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            Session::put('user', ['email' => $this->email]);
            return redirect()->intended('/admin');
        }

        $this->addError('email', 'Estas credenciales no coinciden con nuestros registros.'); */


        dd('fog');
    }


    public function render()
    {

        return view('livewire.login-form');
    }
}
