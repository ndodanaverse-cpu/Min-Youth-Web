<?php

namespace App\Livewire\Campaign;

use App\Models\Campaign;
use Livewire\Component;

class Show extends Component
{
    public Campaign $campaign;

    public function mount(Campaign $campaign): void
    {
        abort_unless($campaign->isPublished(), 404);

        $this->campaign = $campaign;
    }

    public function render()
    {
        return view('livewire.campaign.show', [
            'related' => Campaign::published()
                ->where('id', '!=', $this->campaign->id)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ])
            ->layout('layouts.landing', [
                'title' => $this->campaign->title,
                'description' => $this->campaign->summary,
                'image' => $this->campaign->hero_image,
                'canonical' => route('campaign.show', $this->campaign),
                'type' => 'article',
            ]);
    }
}
