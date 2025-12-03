<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Fleet extends Component
{
    public function render()
    {
        return view('livewire.admin.fleet')
            ->layout('layout.base-drawer');
    }
}
