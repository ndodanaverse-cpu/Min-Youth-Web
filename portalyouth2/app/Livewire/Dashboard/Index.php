<?php

namespace App\Livewire\Dashboard;

use App\Models\Opportunity;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.dashboard.index', [
            'applicationsCount' => $user->applications()->count(),
            'savedCount' => $user->savedOpportunities()->count(),
            'openCount' => Opportunity::published()
                ->where(function ($q) {
                    $q->whereNull('deadline_at')->orWhere('deadline_at', '>=', now());
                })
                ->count(),
            'recentApplications' => $user->applications()
                ->with('opportunity')
                ->latest()
                ->limit(5)
                ->get(),
            'profile' => $user->profile,
        ])->layout('layouts.dashboard', ['title' => 'Overview']);
    }
}
