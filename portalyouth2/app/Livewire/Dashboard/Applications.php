<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Applications extends Component
{
    public function render()
    {
        return view('livewire.dashboard.applications', [
            'applications' => auth()->user()->applications()
                ->with('opportunity')
                ->latest()
                ->get(),
        ])->layout('layouts.dashboard', ['title' => 'My applications']);
    }
}
