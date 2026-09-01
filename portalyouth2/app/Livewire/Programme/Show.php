<?php

namespace App\Livewire\Programme;

use App\Models\Programme;
use Livewire\Component;

class Show extends Component
{
    public Programme $programme;

    public function mount(Programme $programme): void
    {
        abort_unless($programme->isPublished(), 404);

        $this->programme = $programme;
    }

    public function render()
    {
        return view('livewire.programme.show', [
            'stories' => $this->programme->successStories?->take(3) ?? collect(),
            'related' => Programme::published()
                ->where('id', '!=', $this->programme->id)
                ->limit(3)
                ->get(),
        ])
            ->layout('layouts.landing', [
                'title' => $this->programme->title,
                'description' => $this->programme->summary,
                'image' => $this->programme->image_url,
                'canonical' => route('programme.show', $this->programme),
                'type' => 'article',
            ]);
    }
}
