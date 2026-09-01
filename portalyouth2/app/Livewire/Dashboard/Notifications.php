<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Notifications extends Component
{
    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.dashboard.notifications', [
            'notifications' => auth()->user()
                ->notifications()
                ->latest()
                ->limit(20)
                ->get(),
        ])->layout('layouts.dashboard', ['title' => 'Notifications']);
    }
}
