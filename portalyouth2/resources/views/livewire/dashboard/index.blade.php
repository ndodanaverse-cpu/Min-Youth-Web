<div class="mx-auto max-w-5xl">
    {{-- Welcome --}}
    <div class="rounded-[1.5rem] bg-gov-950 p-7 text-white sm:p-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-300">Welcome back</p>
        <h2 class="mt-2 font-display text-2xl font-bold sm:text-3xl">Hello, {{ auth()->user()->name }} 👋</h2>
        <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/70 sm:text-base">
            @if ($profile)
                You're registered in <strong class="text-white">{{ $profile->province?->name }}</strong>.
                Your next step is applying to opportunities that match your interests.
            @else
                Complete your profile to unlock personalised opportunities and applications.
            @endif
        </p>
        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('dashboard.opportunities') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                Browse opportunities
                <x-icon name="arrow-right" class="size-4" />
            </a>
            @if (! $profile)
                <a href="{{ route('dashboard.profile') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-white/10">
                    Complete my profile
                </a>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <dl class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
            <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gov-50 text-gov-700">
                <x-icon name="clipboard" class="size-5" />
            </span>
            <dd class="mt-4 font-numbers text-3xl font-bold text-charcoal-900">{{ $applicationsCount }}</dd>
            <dt class="mt-1 text-xs font-medium uppercase tracking-wider text-charcoal-500">Applications sent</dt>
        </div>
        <div class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
            <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gold-100 text-gold-800">
                <x-icon name="star" class="size-5" />
            </span>
            <dd class="mt-4 font-numbers text-3xl font-bold text-charcoal-900">{{ $savedCount }}</dd>
            <dt class="mt-1 text-xs font-medium uppercase tracking-wider text-charcoal-500">Saved opportunities</dt>
        </div>
        <div class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
            <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gov-50 text-gov-700">
                <x-icon name="briefcase" class="size-5" />
            </span>
            <dd class="mt-4 font-numbers text-3xl font-bold text-charcoal-900">{{ $openCount }}</dd>
            <dt class="mt-1 text-xs font-medium uppercase tracking-wider text-charcoal-500">Open opportunities</dt>
        </div>
    </dl>

    {{-- Recent applications --}}
    <div class="mt-10">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-lg font-bold text-charcoal-900">Recent applications</h2>
            <a href="{{ route('dashboard.applications') }}" class="text-sm font-semibold text-gov-700 hover:text-gov-600">View all</a>
        </div>

        @if ($recentApplications->isEmpty())
            <div class="mt-4 flex flex-col items-center rounded-[1.25rem] border border-dashed border-charcoal-200 bg-white px-6 py-12 text-center">
                <x-icon name="clipboard" class="size-8 text-charcoal-300" />
                <p class="mt-3 text-sm text-charcoal-600">You haven't applied to anything yet.</p>
                <a href="{{ route('dashboard.opportunities') }}" class="mt-4 text-sm font-semibold text-gov-700 hover:text-gov-600">Find your first opportunity →</a>
            </div>
        @else
            <ul class="mt-4 space-y-3">
                @foreach ($recentApplications as $application)
                    <li class="flex items-center justify-between gap-4 rounded-[1.25rem] border border-charcoal-100 bg-white p-5 shadow-soft">
                        <div class="min-w-0">
                            <a href="{{ route('opportunity.show', $application->opportunity) }}" class="font-display text-sm font-bold text-charcoal-900 hover:text-gov-700">
                                {{ $application->opportunity->title }}
                            </a>
                            <p class="mt-1 text-xs text-charcoal-500">{{ $application->submitted_at?->diffForHumans() }}</p>
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
</div>
