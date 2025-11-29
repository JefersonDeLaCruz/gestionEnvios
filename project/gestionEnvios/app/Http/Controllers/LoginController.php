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

    public function login(Request $request) // iniciar sesión
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        if (Auth::attempt($credentials)) {
            Session::put('user', $credentials);
            
            // Obtener el usuario autenticado
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Redirigir según el rol del usuario
            if ($user->hasRole('admin')) {
                return redirect()->route('admin');
            } elseif ($user->hasRole('repartidor')) {
                return redirect()->route('repartidor');
            }

            // Si no tiene ningún rol específico, redirigir a home
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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
