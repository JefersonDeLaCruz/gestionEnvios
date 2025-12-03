<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //

    public function index()
    {
        if (auth()->check()) {
            auth()->logout();
            return view('cliente.index');
        } else {
            return view('cliente.index');
        }
    }
}
