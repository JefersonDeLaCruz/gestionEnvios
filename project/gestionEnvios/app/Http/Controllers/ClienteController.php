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
            return redirect()->route('login');
        } else {
            return redirect()->route('login');
        }
    }
}
