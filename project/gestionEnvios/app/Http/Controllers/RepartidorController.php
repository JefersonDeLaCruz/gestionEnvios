<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepartidorController extends Controller
{
    

    public function index()
    {
        return view('repartidor.index');
    }
}
