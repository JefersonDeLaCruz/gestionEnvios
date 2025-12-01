<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Models\User;



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
    // Reglas de validación (email y telefono únicos)
    $rules = [
        'nombre'   => ['required', 'string', 'max:50'],
        'apellido' => ['required', 'string', 'max:50'],
        'telefono' => ['required', 'string', 'min:8', 'max:12', Rule::unique('users', 'telefono')],
        'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
        'password' => ['required', 'string', 'min:8', 'confirmed'], // si usas password_confirmation
    ];

    $validatedData = $request->validate($rules);

    DB::beginTransaction();

    try {
        $user = User::create([
            'nombre'    => $validatedData['nombre'],
            'apellido'  => $validatedData['apellido'],
            'telefono'  => $validatedData['telefono'],
            'email'     => $validatedData['email'],
            'password'  => Hash::make($validatedData['password']),
            'direccion' => $request->input('direccion', 'N/A'),
            'estado'    => 1, // opcional, según tu lógica
        ]);

        DB::commit();

        // Loguear y guardar sólo datos no sensibles en sesión
        Auth::login($user);
        Session::put('user', $user->only('id', 'email', 'nombre'));

        return redirect()->route('home')->with('success', 'Registro exitoso! Bienvenido!');
    } catch (QueryException $e) {
        DB::rollBack();

        $errorCode = $e->errorInfo[1] ?? null;

        if ($errorCode == 1062) { // duplicado en MySQL
            $message = $e->getMessage();
            $column = null;

            if (preg_match("/for key '(.+)'/", $message, $matches)) {
                $keyName = $matches[1]; // ej: users_email_unique
                if (preg_match("/email/", $keyName)) {
                    $column = 'email';
                } elseif (preg_match("/telefono|phone/", $keyName)) {
                    $column = 'telefono';
                }
            }

            if ($column) {
                return back()
                    ->withErrors([$column => 'Ya existe un usuario con ese ' . $column . '.'])
                    ->withInput();
            }

            return back()
                ->withErrors(['email' => 'Ya existe un usuario con algunos de los datos ingresados.'])
                ->withInput();
        }

        // Otro error de BD inesperado
        // logger()->error($e->getMessage());
        return back()
            ->withErrors(['error' => 'Ocurrió un error al registrar el usuario. Intenta de nuevo.'])
            ->withInput();
    } catch (\Exception $e) {
        DB::rollBack();
        // logger()->error($e->getMessage());
        return back()
            ->withErrors(['error' => 'Ocurrió un error inesperado. Contacta al administrador.'])
            ->withInput();
    }
}

}
