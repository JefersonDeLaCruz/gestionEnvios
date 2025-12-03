<?php

namespace App\Livewire\Repartidor;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.repartidor.profile')
            ->layout('layout.base-drawer');
    }
}
