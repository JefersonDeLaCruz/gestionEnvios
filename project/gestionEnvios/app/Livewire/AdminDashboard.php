<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class AdminDashboard extends Component
{
    public $activeTab = 'dashboard';

    #[On('switch-tab')]
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
