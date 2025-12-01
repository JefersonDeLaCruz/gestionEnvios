<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{


    public function index() // mostrar la vista de login
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            // Mensaje genérico para evitar enumeración de usuarios
            return back()->withErrors(['email' => 'Credenciales inválidas.']);
        }

        // Asumiendo estado 1 = activo
        if ($user->estado != 1) {
            return back()->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        // Verificar contraseña (opcional antes de Auth::attempt)
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Credenciales inválidas.']);
        }

        // Si todo OK, loguear
        Auth::login($user);
        Session::put('user', $user->only('id', 'email'));

        if ($user->hasRole('admin')) return redirect()->route('admin');
        if ($user->hasRole('repartidor')) return redirect()->route('repartidor');

        return redirect()->route('home');
    }

    public function logout(Request $request) // cerrar sesión
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(Request $request) // registrar un nuevo usuario
    {
        $validatedData = $request->validate([
            'nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'telefono' => ['required', 'string', 'min:8', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'telefono' => $validatedData['telefono'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'direccion' => 'N/A', // Temporal hasta agregar campo al formulario
        ]);

        Auth::login($user);

        Session::put('user', $validatedData);

        return redirect()->route('home')->with('success', 'Registro exitoso! Bienvenido!');
    }
}
