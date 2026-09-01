<?php

namespace App\Livewire\Components;

use App\Models\NewsletterSubscription;
use Livewire\Attributes\Rule;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    #[Rule(['required', 'email', 'max:190'])]
    public string $email = '';

    #[Rule(['nullable', 'string', 'max:100'])]
    public ?string $first_name = null;

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate();

        NewsletterSubscription::updateOrCreate(
            ['email' => $this->email],
            ['first_name' => $this->first_name, 'is_active' => true, 'subscribed_at' => now()]
        );

        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.components.newsletter-subscribe');
    }
}
