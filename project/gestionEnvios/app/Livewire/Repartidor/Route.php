<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

class Route extends Component
{
    public function render()
    {
        return view('livewire.repartidor.route')
            ->layout('layout.base-drawer');
    }
}
