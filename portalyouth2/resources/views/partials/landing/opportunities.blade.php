<section id="opportunities" aria-labelledby="opportunities-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <x-section-heading
                eyebrow="Seize the moment"
                title="Live opportunities"
                description="Funding, jobs, training and competitions — apply before the deadline closes."
            />

            <div wire:ignore class="no-scrollbar -mx-4 flex gap-2 overflow-x-auto px-4 sm:mx-0 sm:flex-wrap sm:px-0" aria-label="Filter opportunities by category">
                @foreach ($this->categories as $option)
                    <button
                        type="button"
                        wire:click="$set('category', '{{ $option['value'] }}')"
                        wire:loading.attr="disabled"
                        @class([
                            'shrink-0 rounded-full border px-4 py-2 text-sm font-semibold transition-colors',
                            'border-gov-700 bg-gov-700 text-white' => $category === $option['value'],
                            'border-charcoal-200 bg-white text-charcoal-700 hover:border-gov-300 hover:text-gov-700' => $category !== $option['value'],
                        ])
                        aria-pressed="{{ $category === $option['value'] ? 'true' : 'false' }}"
                    >
                        {{ $option['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <div data-reveal class="relative mt-10 overflow-hidden rounded-[2rem] shadow-soft">
            <img
                src="{{ asset('img/opportunity-youth.jpg') }}"
                alt="Young Zimbabweans at an opportunity and funding event"
                width="2560"
                height="1920"
                loading="lazy"
                class="h-64 w-full object-cover sm:h-80"
            >
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-gov-950/80 via-gov-950/20 to-transparent" aria-hidden="true"></div>
            <div class="absolute inset-x-0 bottom-0 flex flex-col gap-4 p-6 sm:flex-row sm:items-end sm:justify-between sm:p-8">
                <div class="max-w-xl">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gold-300">Spotlight</p>
                    <h3 class="mt-1.5 font-display text-xl font-bold text-white sm:text-2xl">EmpowerBank Youth Fund</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-white/80">
                        Zero-collateral funding of up to USD 100,000 for young Zimbabwean entrepreneurs aged 18–35.
                    </p>
                </div>
                <a href="#opportunities"
                   class="group inline-flex shrink-0 items-center gap-2 rounded-full bg-gold-400 px-6 py-3 text-sm font-semibold text-charcoal-900 shadow-soft transition-all duration-200 hover:-translate-y-0.5 hover:bg-gold-300">
                    Browse opportunities
                    <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1" />
                </a>
            </div>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($opportunities as $opportunity)
                <article class="group flex flex-col overflow-hidden rounded-[1.5rem] border border-charcoal-100 bg-white shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-lift">
                    <div class="relative">
                        <div class="h-44 overflow-hidden">
                            <x-remote-img
                                src="{{ $opportunity->image_url }}"
                                alt="{{ $opportunity->title }}"
                                width="640" height="352"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                label="Opportunity"
                            />
                        </div>
                        <span class="absolute left-4 top-4 rounded-full bg-charcoal-900/80 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                            {{ $opportunity->category->label() }}
                        </span>
                        @if ($opportunity->isClosed())
                            <span class="absolute right-4 top-4 rounded-full bg-red-600 px-3 py-1 text-xs font-semibold text-white">
                                Closed
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="font-display text-base font-bold leading-snug text-charcoal-900">
                            <a href="{{ route('opportunity.show', $opportunity) }}" class="focus:rounded focus:outline-none focus:ring-2 focus:ring-gov-500">
                                {{ $opportunity->title }}
                            </a>
                        </h3>

                        <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-medium text-charcoal-500">
                            @if ($opportunity->organizer)
                                <span class="inline-flex items-center gap-1.5">
                                    <x-icon name="building-office" class="size-4 text-gov-600" />
                                    {{ $opportunity->organizer }}
                                </span>
                            @endif
                            @if ($opportunity->province)
                                <span class="inline-flex items-center gap-1.5">
                                    <x-icon name="map-pin" class="size-4 text-gov-600" />
                                    {{ $opportunity->province->name }}
                                </span>
                            @endif
                        </div>

                        @if ($opportunity->deadline_at)
                            <div class="mt-5 flex items-center justify-between rounded-xl bg-gov-50 px-4 py-3">
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-gov-700">
                                    <x-icon name="clock" class="size-4" />
                                    {{ $opportunity->isClosed() ? 'Deadline passed' : 'Deadline' }}
                                </span>
                                <span class="text-sm font-bold text-gov-800">
                                    {{ $opportunity->isClosed() ? $opportunity->deadline_at->format('d M Y') : $opportunity->deadline_at->diffForHumans() }}
                                </span>
                            </div>
                        @endif

                        <p class="mt-5 flex items-center gap-2 text-sm font-semibold text-gov-700">
                            View opportunity
                            <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1" />
                        </p>
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 lg:col-span-3">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>
    </div>
</section>
