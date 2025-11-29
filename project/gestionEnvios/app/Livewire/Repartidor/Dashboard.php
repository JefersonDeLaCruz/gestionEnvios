<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.repartidor.dashboard')
            ->layout('layout.base-drawer');
    }
}
