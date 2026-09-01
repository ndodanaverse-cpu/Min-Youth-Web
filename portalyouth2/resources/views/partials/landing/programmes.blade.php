<section id="programmes" aria-labelledby="programmes-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="What we do"
            title="Programmes for every young Zimbabwean"
            description="From starting a business to mastering a trade — explore the government's youth development programmes and find your path."
            align="center"
        />

        <div data-reveal-group class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($programmes as $programme)
                <article data-reveal
                         class="group relative flex flex-col rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:border-gov-200 hover:shadow-lift">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex size-13 items-center justify-center rounded-2xl bg-gov-50 text-gov-700 transition-colors group-hover:bg-gov-600 group-hover:text-white">
                            <x-icon name="{{ match ($programme->category->value) {
                                'agriculture' => 'leaf',
                                'ict', 'innovation' => 'rocket',
                                'sports' => 'trophy',
                                'volunteerism' => 'hand-raised',
                                'vocational_training' => 'wrench',
                                'women_empowerment' => 'heart',
                                'youth_funding' => 'banknotes',
                                default => 'graduation-cap',
                            } }}" class="size-6" />
                        </span>
                        <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-semibold text-gold-800">
                            {{ $programme->category->label() }}
                        </span>
                    </div>

                    <h3 class="mt-6 font-display text-lg font-bold leading-snug text-charcoal-900">
                        <a href="{{ route('programme.show', $programme) }}" class="focus:rounded focus:outline-none focus:ring-2 focus:ring-gov-500">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $programme->title }}
                        </a>
                    </h3>
                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-charcoal-600">
                        {{ $programme->summary }}
                    </p>

                    <p class="mt-6 flex items-center gap-2 text-sm font-semibold text-gov-700">
                        Learn more
                        <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1" />
                    </p>
                </article>
            @empty
                <div class="sm:col-span-2 lg:col-span-3">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>
    </div>
</section>
