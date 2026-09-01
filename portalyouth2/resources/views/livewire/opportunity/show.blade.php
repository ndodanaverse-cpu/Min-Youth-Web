<div>
    {{-- Breadcrumb --}}
    <div class="border-b border-charcoal-100 bg-mist-50">
        <nav class="mx-auto flex max-w-7xl items-center gap-2 px-4 py-4 text-xs font-medium text-charcoal-500 sm:px-6 lg:px-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-gov-700">Home</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <a href="{{ route('home').'#opportunities' }}" class="hover:text-gov-700">Opportunities</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <span class="truncate text-charcoal-900" aria-current="page">{{ $opportunity->title }}</span>
        </nav>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-12 lg:grid-cols-3">
            {{-- Main --}}
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-gov-100 px-3 py-1 text-xs font-semibold text-gov-800">{{ $opportunity->category->label() }}</span>
                    @if ($opportunity->isClosed())
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Applications closed</span>
                    @else
                        <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-semibold text-gold-800">Open now</span>
                    @endif
                </div>

                <h1 class="mt-4 font-display text-3xl font-bold leading-tight tracking-tight text-charcoal-900 sm:text-4xl">{{ $opportunity->title }}</h1>

                <p class="mt-4 text-lg leading-relaxed text-charcoal-600">{{ $opportunity->summary }}</p>

                <div class="mt-8 overflow-hidden rounded-[1.5rem]">
                    <x-remote-img
                        src="{{ $opportunity->image_url }}"
                        alt="{{ $opportunity->title }}"
                        width="1200" height="675"
                        class="aspect-video w-full object-cover"
                        label="Opportunity"
                    />
                </div>

                <div class="prose prose-gov mt-10 max-w-none">
                    {!! $opportunity->description !!}
                </div>

                @if ($opportunity->eligibility)
                    <div class="mt-10 rounded-[1.5rem] border border-gov-100 bg-gov-50/60 p-7">
                        <h2 class="flex items-center gap-2 font-display text-lg font-bold text-charcoal-900">
                            <x-icon name="check-circle" class="size-5 text-gov-600" />
                            Who can apply
                        </h2>
                        <div class="prose prose-sm prose-gov mt-4 max-w-none">
                            {!! $opportunity->eligibility !!}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24 space-y-5">
                    <div class="rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft">
                        <h2 class="font-display text-sm font-semibold uppercase tracking-widest text-charcoal-500">Key details</h2>
                        <dl class="mt-5 space-y-4 text-sm">
                            @if ($opportunity->organizer)
                                <div class="flex items-start gap-3">
                                    <x-icon name="building-office" class="mt-0.5 size-5 shrink-0 text-gov-600" />
                                    <div>
                                        <dt class="text-xs text-charcoal-500">Organizer</dt>
                                        <dd class="mt-0.5 font-semibold text-charcoal-900">{{ $opportunity->organizer }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($opportunity->province)
                                <div class="flex items-start gap-3">
                                    <x-icon name="map-pin" class="mt-0.5 size-5 shrink-0 text-gov-600" />
                                    <div>
                                        <dt class="text-xs text-charcoal-500">Location</dt>
                                        <dd class="mt-0.5 font-semibold text-charcoal-900">{{ $opportunity->province->name }}{{ $opportunity->district ? ' · '.$opportunity->district->name : '' }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($opportunity->funding_amount)
                                <div class="flex items-start gap-3">
                                    <x-icon name="banknotes" class="mt-0.5 size-5 shrink-0 text-gov-600" />
                                    <div>
                                        <dt class="text-xs text-charcoal-500">Funding available</dt>
                                        <dd class="mt-0.5 font-semibold text-charcoal-900">{{ $opportunity->funding_amount }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($opportunity->deadline_at)
                                <div class="flex items-start gap-3">
                                    <x-icon name="clock" class="mt-0.5 size-5 shrink-0 text-gov-600" />
                                    <div>
                                        <dt class="text-xs text-charcoal-500">Deadline</dt>
                                        <dd class="mt-0.5 font-semibold {{ $opportunity->isClosed() ? 'text-red-600' : 'text-charcoal-900' }}">
                                            {{ $opportunity->deadline_at->format('d M Y, H:i') }}
                                        </dd>
                                    </div>
                                </div>
                            @endif
                        </dl>

                        <div class="mt-7">
                            @auth
                                @if ($opportunity->isClosed())
                                    <p class="rounded-xl bg-red-50 px-4 py-3 text-center text-sm font-semibold text-red-700">This opportunity has closed.</p>
                                @else
                                    <a href="#"
                                       class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                                        Apply now
                                        <x-icon name="arrow-right" class="size-4" />
                                    </a>
                                @endif
                            @else
                                @if ($opportunity->isClosed())
                                    <p class="rounded-xl bg-red-50 px-4 py-3 text-center text-sm font-semibold text-red-700">This opportunity has closed.</p>
                                @else
                                    <a href="{{ route('register') }}"
                                       class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                                        Register to apply
                                        <x-icon name="arrow-right" class="size-4" />
                                    </a>
                                    <p class="mt-3 text-center text-xs text-charcoal-500">Free account · Verified in minutes</p>
                                @endif
                            @endauth
                        </div>
                    </div>

                    @if ($opportunity->apply_url)
                        <a href="{{ $opportunity->apply_url }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 rounded-full border border-charcoal-200 px-6 py-3.5 text-sm font-semibold text-gov-700 transition-colors hover:border-gov-700 hover:bg-gov-700 hover:text-white">
                            External application
                            <x-icon name="external-link" class="size-4" />
                        </a>
                    @endif
                </div>
            </aside>
        </div>

        {{-- Related --}}
        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-charcoal-100 pt-12">
                <h2 class="font-display text-xl font-bold text-charcoal-900">More opportunities for you</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('opportunity.show', $item) }}" class="group rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-lift">
                            <span class="text-xs font-semibold uppercase tracking-widest text-gov-600">{{ $item->category->label() }}</span>
                            <h3 class="mt-2 font-display text-base font-bold leading-snug text-charcoal-900 group-hover:text-gov-700">{{ $item->title }}</h3>
                            @if ($item->deadline_at)
                                <p class="mt-3 text-xs font-medium text-charcoal-500">Deadline {{ $item->deadline_at->format('d M Y') }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
