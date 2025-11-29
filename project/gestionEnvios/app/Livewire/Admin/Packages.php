<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Packages extends Component
{
    public function render()
    {
        return view('livewire.admin.packages')
            ->layout('layout.base-drawer');
    }
}
