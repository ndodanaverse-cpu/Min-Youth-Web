<?php

namespace App\Livewire\News;

use App\Models\News;
use Livewire\Component;

class Show extends Component
{
    public News $news;

    public function mount(News $news): void
    {
        abort_unless($news->isPublished(), 404);

        $this->news = $news;
    }

    public function render()
    {
        return view('livewire.news.show', [
            'related' => News::published()
                ->where('id', '!=', $this->news->id)
                ->orderByDesc('published_at')
                ->limit(3)
                ->get(),
        ])
            ->layout('layouts.landing', [
                'title' => $this->news->title,
                'description' => $this->news->summary,
                'image' => $this->news->cover_image,
                'canonical' => route('news.show', $this->news),
                'type' => 'article',
            ]);
    }
}
