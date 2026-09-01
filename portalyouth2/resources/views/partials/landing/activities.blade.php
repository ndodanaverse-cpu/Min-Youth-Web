<section id="activities" aria-labelledby="activities-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="Mark your calendar"
            title="Upcoming events & activities"
            description="Workshops, forums, trainings and national events organised for and by young people across all 10 provinces."
            align="center"
        />

        <div data-reveal-group class="mx-auto mt-14 grid max-w-5xl gap-6 lg:grid-cols-3">
            @forelse ($activities as $activity)
                <article data-reveal class="flex gap-5 rounded-[1.5rem] border border-charcoal-100 bg-white p-6 shadow-soft">
                    @if ($activity->starts_at)
                        <div class="flex shrink-0 flex-col items-center justify-center rounded-2xl bg-gov-700 px-4 py-3 text-white">
                            <span class="font-numbers text-2xl font-bold leading-none">{{ $activity->starts_at->format('d') }}</span>
                            <span class="mt-1 text-[0.65rem] font-semibold uppercase tracking-widest text-gold-300">{{ $activity->starts_at->format('M') }}</span>
                        </div>
                    @else
                        <div class="flex shrink-0 flex-col items-center justify-center rounded-2xl bg-gold-100 px-4 py-3 text-gold-800">
                            <x-icon name="calendar" class="size-6" />
                        </div>
                    @endif

                    <div class="min-w-0">
                        <span class="text-[0.65rem] font-semibold uppercase tracking-widest text-gov-600">{{ $activity->type->label() }}</span>
                        <h3 class="mt-1.5 font-display text-base font-bold leading-snug text-charcoal-900">{{ $activity->title }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-charcoal-600">{{ $activity->summary }}</p>
                        <p class="mt-3 flex items-center gap-1.5 truncate text-xs font-medium text-charcoal-500">
                            <x-icon name="location" class="size-4 shrink-0 text-gov-600" />
                            <span class="truncate">{{ $activity->venue ?: ($activity->province->name ?? 'Location to be announced') }}</span>
                        </p>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>
    </div>
</section>
