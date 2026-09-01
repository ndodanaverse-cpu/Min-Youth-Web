@php
    $stats = $stats ?? [
        ['value' => 10, 'suffix' => '', 'label' => 'Provinces covered'],
        ['value' => 15, 'suffix' => '+', 'label' => 'Youth Programmes'],
        ['value' => 40, 'suffix' => '+', 'label' => 'Opportunities live'],
        ['value' => 60, 'suffix' => '%', 'label' => 'Population is young'],
    ];
@endphp

<section id="home" aria-label="Welcome" class="relative isolate overflow-hidden bg-gov-950 pt-32 pb-20 sm:pt-40 lg:pt-44 lg:pb-28">
    {{-- Geometric background --}}
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -top-40 -right-40 size-[36rem] rounded-full bg-gov-700/30 blur-3xl"></div>
        <div class="absolute top-1/3 -left-48 size-[30rem] rounded-full bg-gold-500/10 blur-3xl"></div>
        <svg class="absolute inset-0 h-full w-full text-white/[0.04]" width="100%" height="100%">
            <defs>
                <pattern id="zimgrid" width="72" height="72" patternUnits="userSpaceOnUse">
                    <path d="M36 8 64 36 36 64 8 36Z" fill="none" stroke="currentColor" stroke-width="1"/>
                    <circle cx="36" cy="36" r="2.5" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#zimgrid)"/>
        </svg>
        <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-gov-950 to-transparent"></div>
    </div>

    <div class="mx-auto grid max-w-7xl items-center gap-16 px-4 sm:px-6 lg:grid-cols-2 lg:gap-12 lg:px-8">
        {{-- Left --}}
        <div class="max-w-2xl">
            <div data-reveal class="inline-flex items-center gap-2.5 rounded-full border border-gold-400/30 bg-gold-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gold-300">
                <span class="size-2 rounded-full bg-gold-400"></span>
                Official Government Youth Portal
            </div>

            <h1 data-reveal class="mt-6 font-display text-4xl font-bold leading-[1.08] tracking-tight text-white text-balance sm:text-5xl lg:text-6xl">
                Your Potential.
                <span class="text-gold-400">Zimbabwe's Future.</span>
            </h1>

            <p data-reveal class="mt-6 max-w-xl text-lg leading-relaxed text-white/75">
                Join the national portal connecting young Zimbabweans aged 15–35 to government programmes,
                funding, skills, opportunities and campaigns — from {{ config('portal.ministry') }}.
            </p>

            <div data-reveal class="mt-9 flex flex-col gap-4 sm:flex-row sm:items-center">
                <a href="{{ route('register') }}"
                   class="group inline-flex items-center justify-center gap-3 rounded-full bg-gold-400 px-8 py-4 text-base font-semibold text-charcoal-900 shadow-lift transition-all duration-200 hover:-translate-y-0.5 hover:bg-gold-300">
                    Register Now
                    <x-icon name="arrow-right" class="size-5 transition-transform group-hover:translate-x-1" />
                </a>
                <a href="#programmes"
                   class="inline-flex items-center justify-center gap-3 rounded-full border border-white/20 px-8 py-4 text-base font-semibold text-white transition-colors duration-200 hover:bg-white/10">
                    Explore Programmes
                    <x-icon name="chevron-down" class="size-5" />
                </a>
            </div>

            <dl data-reveal-group class="mt-14 grid grid-cols-2 gap-x-8 gap-y-10 border-t border-white/10 pt-10 sm:grid-cols-4 lg:gap-x-6">
                @foreach ($stats as $stat)
                    <div class="flex flex-col gap-1">
                        <dd class="font-numbers text-3xl font-bold text-white sm:text-4xl">
                            <span data-counter data-counter="{{ $stat['value'] }}" data-suffix="{{ $stat['suffix'] ?? '' }}">0{{ $stat['suffix'] ?? '' }}</span>
                        </dd>
                        <dt class="text-xs font-medium uppercase tracking-wider text-white/50">{{ $stat['label'] }}</dt>
                    </div>
                @endforeach
            </dl>
        </div>

        {{-- Right: feature image with floating cards --}}
        <div class="relative lg:pl-6">
            <div data-reveal class="relative">
                <div class="overflow-hidden rounded-[2rem] shadow-lift ring-1 ring-white/10">
                    <img
                        src="{{ asset('img/hero-youth.jpg') }}"
                        alt="Young Zimbabweans taking part in a youth empowerment programme"
                        width="2560"
                        height="1920"
                        fetchpriority="high"
                        class="aspect-[4/3] w-full object-cover"
                    >
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-gov-950/40 via-transparent to-transparent" aria-hidden="true"></div>
                </div>

                {{-- Floating rectangle cards on the corners --}}
                <div data-reveal class="absolute -top-5 left-4 flex items-center gap-3 rounded-2xl border border-white/15 bg-white/10 px-4 py-3 shadow-lift backdrop-blur-md sm:-left-4">
                    <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-xl bg-gold-400 text-charcoal-900">
                        <x-icon name="sparkles" class="size-5" />
                    </span>
                    <div>
                        <p class="font-display text-sm font-semibold text-white">Programme &amp; Funding Hub</p>
                        <p class="text-xs text-white/65">Everything youth, one portal</p>
                    </div>
                </div>

                <div data-reveal class="absolute top-1/2 -right-3 -translate-y-1/2 rounded-2xl border border-gold-400/30 bg-gov-900/80 px-4 py-3 shadow-lift backdrop-blur-md sm:-right-5">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex size-10 shrink-0 items-center justify-center rounded-xl bg-gold-400 text-charcoal-900">
                            <x-icon name="bolt" class="size-5" />
                        </span>
                        <div>
                            <p class="font-display text-sm font-semibold text-white">EmpowerBank Youth Fund</p>
                            <p class="text-xs text-gold-300">Funding for young innovators</p>
                        </div>
                    </div>
                </div>

                <div data-reveal class="absolute -bottom-6 left-4 flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 shadow-lift backdrop-blur-md sm:left-8">
                    <span class="inline-flex size-12 shrink-0 items-center justify-center rounded-xl bg-gold-400 text-charcoal-900">
                        <x-icon name="check-circle" class="size-6" />
                    </span>
                    <div class="min-w-0">
                        <p class="truncate font-display text-sm font-semibold text-white">Build, learn &amp; grow with us</p>
                        <p class="text-xs text-white/65">Free to join · Powered by the Ministry of Youth</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 lg:block" aria-hidden="true">
        <a href="#programmes" class="flex h-12 w-7 items-start justify-center rounded-full border border-white/25 p-1.5">
            <span class="size-2 animate-bounce rounded-full bg-gold-400"></span>
        </a>
    </div>
</section>
