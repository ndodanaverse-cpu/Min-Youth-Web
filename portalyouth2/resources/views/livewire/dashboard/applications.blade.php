<div class="mx-auto max-w-4xl">
    <h2 class="font-display text-lg font-bold text-charcoal-900">Your applications</h2>
    <p class="mt-1 text-sm text-charcoal-500">Track the status of every opportunity you've applied to.</p>

    @if ($applications->isEmpty())
        <div class="mt-6 flex flex-col items-center rounded-[1.25rem] border border-dashed border-charcoal-200 bg-white px-6 py-16 text-center">
            <x-icon name="clipboard" class="size-8 text-charcoal-300" />
            <p class="mt-3 text-sm text-charcoal-600">You haven't applied to any opportunities yet.</p>
            <a href="{{ route('dashboard.opportunities') }}" class="mt-4 rounded-full bg-gold-400 px-6 py-2.5 text-sm font-semibold text-charcoal-900 hover:bg-gold-300">
                Browse opportunities
            </a>
        </div>
    @else
        <ul class="mt-6 space-y-4">
            @foreach ($applications as $application)
                <li class="flex items-center justify-between gap-4 rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
                    <div class="min-w-0">
                        <a href="{{ route('opportunity.show', $application->opportunity) }}" class="font-display text-base font-bold text-charcoal-900 hover:text-gov-700">
                            {{ $application->opportunity->title }}
                        </a>
                        <p class="mt-1.5 text-sm text-charcoal-600">
                            @if ($application->opportunity->organizer)
                                {{ $application->opportunity->organizer }} ·
                            @endif
                            Applied {{ $application->submitted_at?->format('d M Y') }}
                        </p>
                        @if ($application->admin_notes)
                            <p class="mt-2 rounded-xl bg-mist-50 px-3 py-2 text-xs text-charcoal-500">{{ $application->admin_notes }}</p>
                        @endif
                    </div>
                    <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ match ($application->status->color()) {
                        'success' => 'bg-gov-100 text-gov-800',
                        'danger' => 'bg-red-100 text-red-700',
                        'warning' => 'bg-gold-100 text-gold-800',
                        default => 'bg-mist-100 text-charcoal-600',
                    } }}">
                        {{ $application->status->label() }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
