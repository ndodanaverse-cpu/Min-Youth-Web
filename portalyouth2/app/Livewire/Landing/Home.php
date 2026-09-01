<?php

namespace App\Livewire\Landing;

use App\Enums\OpportunityCategory;
use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Faq;
use App\Models\News;
use App\Models\Opportunity;
use App\Models\Programme;
use App\Models\SuccessStory;
use Illuminate\Support\Collection;
use App\Services\Translation\NllbTranslator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class Home extends Component
{
    #[Url]
    public string $category = 'all';

    public Collection $programmes;

    public Collection $opportunities;

    public Collection $activities;

    public Collection $campaigns;

    public Collection $otherCampaigns;

    public Collection $stories;

    public Collection $newsItems;

    public Collection $faqs;

    public array $stats = [];

    public function mount(): void
    {
        $this->load();
    }

    public function updatedCategory(): void
    {
        $this->loadOpportunities();
        app(NllbTranslator::class)->translateModels($this->opportunities, ['title', 'summary'], app()->getLocale());
    }

    protected function load(): void
    {
        $this->programmes = Programme::published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $this->loadOpportunities();

        $this->activities = Activity::published()
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '>=', now());
            })
            ->orderByRaw('starts_at IS NULL, starts_at ASC')
            ->limit(3)
            ->get();

        $this->campaigns = Campaign::published()
            ->where('is_flagship', true)
            ->orderBy('sort_order')
            ->limit(1)
            ->get()
            ->concat(
                Campaign::published()
                    ->where('is_flagship', false)
                    ->orderBy('sort_order')
                    ->orderByDesc('published_at')
                    ->limit(2)
                    ->get()
            );

        $this->otherCampaigns = Campaign::published()
            ->where('is_flagship', false)
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->limit(2)
            ->get();

        $this->stories = SuccessStory::published()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $this->newsItems = News::published()
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $this->faqs = Faq::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $this->stats = [
            ['value' => 10, 'suffix' => '', 'label' => 'Provinces covered'],
            ['value' => $this->programmes->count(), 'suffix' => '+', 'label' => 'Youth programmes'],
            ['value' => min(Opportunity::published()->count(), 99), 'suffix' => '+', 'label' => 'Opportunities live'],
            ['value' => 60, 'suffix' => '%', 'label' => 'Population is young'],
        ];

        $translator = app(NllbTranslator::class);
        $locale = app()->getLocale();
        $translator->translateModels($this->programmes, ['title', 'summary'], $locale);
        $translator->translateModels($this->opportunities, ['title', 'summary'], $locale);
        $translator->translateModels($this->campaigns, ['title', 'summary'], $locale);
        $translator->translateModels($this->newsItems, ['title', 'summary'], $locale);
    }

    protected function loadOpportunities(): void
    {
        $query = Opportunity::published()
            ->where(function ($q) {
                $q->whereNull('deadline_at')->orWhere('deadline_at', '>=', now());
            });

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        $this->opportunities = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

    }

    #[Computed]
    public function categories(): array
    {
        return [['value' => 'all', 'label' => 'All opportunities'], ...collect(OpportunityCategory::cases())
            ->map(fn (OpportunityCategory $case) => ['value' => $case->value, 'label' => $case->label()])
            ->all()];
    }

    public function render()
    {
        return view('livewire.landing.home')
            ->layout('layouts.landing', [
                'title' => config('portal.name'),
                'description' => 'The official portal connecting young Zimbabweans aged 15-35 to government programmes, funding, skills, opportunities and campaigns.',
            ]);
    }
}
