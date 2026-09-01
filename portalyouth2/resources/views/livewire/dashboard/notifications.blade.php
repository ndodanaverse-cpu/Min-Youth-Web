<div class="mx-auto max-w-4xl">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-lg font-bold text-charcoal-900">Notifications</h2>
            <p class="mt-1 text-sm text-charcoal-500">Updates about your applications, opportunities and the Ministry.</p>
        </div>
        @if ($notifications->isNotEmpty())
            <button type="button" wire:click="markAllAsRead" class="text-sm font-semibold text-gov-700 hover:text-gov-600">
                Mark all as read
            </button>
        @endif
    </div>

    @if ($notifications->isEmpty())
        <div class="mt-6 flex flex-col items-center rounded-[1.25rem] border border-dashed border-charcoal-200 bg-white px-6 py-16 text-center">
            <x-icon name="bell" class="size-8 text-charcoal-300" />
            <p class="mt-3 text-sm text-charcoal-600">You're all caught up. No notifications yet.</p>
        </div>
    @else
        <ul class="mt-6 space-y-3">
            @foreach ($notifications as $notification)
                <li class="flex items-start gap-4 rounded-[1.25rem] border border-charcoal-100 bg-white p-5 shadow-soft">
                    <span @class([
                        'mt-1 inline-flex size-10 shrink-0 items-center justify-center rounded-xl',
                        $notification->read_at ? 'bg-mist-100 text-charcoal-400' : 'bg-gold-100 text-gold-800',
                    ])>
                        <x-icon name="{{ $notification->read_at ? 'envelope' : 'sparkles' }}" class="size-5" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <p class="text-sm font-bold text-charcoal-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <span class="text-xs text-charcoal-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-sm leading-relaxed text-charcoal-600">{{ $notification->data['body'] ?? '' }}</p>
                        @if (! empty($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-gov-700 hover:text-gov-600">
                                View
                                <x-icon name="arrow-right" class="size-3.5" />
                            </a>
                        @endif
                    </div>
                    @if (! $notification->read_at)
                        <span class="mt-2 size-2 shrink-0 rounded-full bg-gold-500" aria-label="Unread"></span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
