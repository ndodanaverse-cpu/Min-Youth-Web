<?php

namespace App\Livewire\Opportunity;

use App\Models\Opportunity;
use Livewire\Component;

class Show extends Component
{
    public Opportunity $opportunity;

    public function mount(Opportunity $opportunity): void
    {
        abort_unless($opportunity->isPublished(), 404);

        $this->opportunity = $opportunity->load(['province', 'district']);
    }

    public function render()
    {
        return view('livewire.opportunity.show', [
            'related' => Opportunity::published()
                ->where('id', '!=', $this->opportunity->id)
                ->where('category', $this->opportunity->category)
                ->limit(3)
                ->get(),
        ])
            ->layout('layouts.landing', [
                'title' => $this->opportunity->title,
                'description' => $this->opportunity->summary,
                'image' => $this->opportunity->image_url,
                'canonical' => route('opportunity.show', $this->opportunity),
                'type' => 'article',
            ]);
    }
}
