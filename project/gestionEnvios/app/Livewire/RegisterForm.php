<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterForm extends Component
{
    //campos modificados para que coincidan con el form
    public $name;
    public $last_name;
    public $phone;
    public $email;
    public $password;

    public function register()
    {
        $this->validate([
            'name'      => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone'     => 'required|numeric|digits_min:8',
            'email'     => 'required|email|unique:users,email',

            //validacion para la contraseña
            'password'  => [
                'required',
                Password::min(8)     // Mínimo 8 caracteres
                    ->letters()      // Al menos una letra
                    ->mixedCase()    // Al menos una mayúscula y una minúscula
                    ->numbers()      // Al menos un número
                    ->symbols()      // Al menos un símbolo (!, @, #, etc.)
                ],
        ]);

        $user = User::create([
            'name'      => $this->name,
            'last_name' => $this->last_name,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'password'  => Hash::make($this->password),
            // You might want to store birthdate if your user model supports it
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}
