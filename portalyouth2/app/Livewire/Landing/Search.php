<?php

namespace App\Livewire\Landing;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Opportunity;
use App\Models\Programme;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class Search extends Component
{
    #[Url]
    public string $q = '';

    #[Url]
    public string $type = 'all';

    public function search(): void
    {
        $this->dispatch('search-submitted');
    }

    #[Computed]
    public function hasQuery(): bool
    {
        return mb_strlen(trim((string) $this->q)) >= 2;
    }

    #[Computed]
    public function results(): array
    {
        if (! $this->hasQuery) {
            return [];
        }

        $q = trim((string) $this->q);
        $results = [];

        if (in_array($this->type, ['all', 'opportunities'], true)) {
            $results['Opportunities'] = Opportunity::published()
                ->where('title', 'like', "%{$q}%")
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        }

        if (in_array($this->type, ['all', 'programmes'], true)) {
            $results['Programmes'] = Programme::published()
                ->where('title', 'like', "%{$q}%")
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        }

        if (in_array($this->type, ['all', 'activities'], true)) {
            $results['Activities'] = Activity::published()
                ->where('title', 'like', "%{$q}%")
                ->orderByDesc('starts_at')
                ->limit(4)
                ->get();
        }

        if (in_array($this->type, ['all', 'campaigns'], true)) {
            $results['Campaigns'] = Campaign::published()
                ->where('title', 'like', "%{$q}%")
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        }

        return array_filter($results, fn ($items) => $items->isNotEmpty());
    }

    #[Computed]
    public function types(): array
    {
        return [
            'all' => 'Everything',
            'opportunities' => 'Opportunities',
            'programmes' => 'Programmes',
            'activities' => 'Activities',
            'campaigns' => 'Campaigns',
        ];
    }

    #[Computed]
    public function resultCount(): int
    {
        return collect($this->results)->sum(fn ($items) => $items->count());
    }

    public function clear(): void
    {
        $this->reset('q', 'type');
    }

    public function render()
    {
        return view('livewire.landing.search');
    }
}
