<?php

namespace App\Livewire\Dashboard;

use App\Models\Opportunity;
use App\Models\SavedOpportunity;
use Livewire\Component;

class Opportunities extends Component
{
    public array $saved = [];

    public function mount(): void
    {
        $this->saved = auth()->user()->savedOpportunities()->pluck('opportunity_id')->map(fn ($id) => (string) $id)->all();
    }

    public function toggleSave(string $opportunityId): void
    {
        $user = auth()->user();

        if (in_array($opportunityId, $this->saved, true)) {
            SavedOpportunity::where('user_id', $user->id)->where('opportunity_id', $opportunityId)->delete();
            $this->saved = array_values(array_diff($this->saved, [$opportunityId]));
        } else {
            SavedOpportunity::updateOrCreate(
                ['user_id' => $user->id, 'opportunity_id' => $opportunityId],
                ['saved_at' => now()]
            );
            $this->saved[] = $opportunityId;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.opportunities', [
            'opportunities' => Opportunity::published()
                ->where(function ($q) {
                    $q->whereNull('deadline_at')->orWhere('deadline_at', '>=', now());
                })
                ->with('province')
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->limit(12)
                ->get(),
        ])->layout('layouts.dashboard', ['title' => 'Opportunities']);
    }
}
