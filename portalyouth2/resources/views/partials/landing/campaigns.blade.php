<section id="campaigns" aria-labelledby="campaigns-heading" class="scroll-mt-section relative py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="Flagship campaign"
            title="Stand firm. Say no to drugs."
            description="A nationwide movement protecting young people from drug and substance abuse — with free, confidential help a call away."
            align="center"
            dark
        />

        @foreach ($campaigns->take(1) as $campaign)
            <div class="mt-14 grid overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 backdrop-blur lg:grid-cols-2">
                {{-- Left: visual + stats --}}
                <div class="relative min-h-72">
                    <x-remote-img
                        src="{{ $campaign->hero_image }}"
                        alt="{{ $campaign->title }}"
                        width="900" height="640"
                        class="absolute inset-0 h-full w-full object-cover"
                        label="Campaign"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-gov-950/90 via-gov-950/30 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                        <span class="inline-flex items-center gap-2 rounded-full bg-gold-400 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-charcoal-900">
                            <x-icon name="megaphone" class="size-4" />
                            {{ $campaign->type->label() }}
                        </span>
                        <h3 class="mt-4 font-display text-2xl font-bold leading-tight text-white sm:text-3xl">{{ $campaign->title }}</h3>
                    </div>
                </div>

                {{-- Right: content --}}
                <div class="flex flex-col justify-between gap-8 p-6 sm:p-10">
                    <div>
                        <p class="leading-relaxed text-white/75">{!! $campaign->summary !!}</p>

                        @if ($campaign->support_services)
                            <div class="mt-8">
                                <h4 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">Free support services</h4>
                                <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                                    @foreach ($campaign->support_services as $service)
                                        <li class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-4">
                                            <x-icon name="hand-raised" class="mt-0.5 size-5 shrink-0 text-gold-400" />
                                            <div>
                                                <p class="text-sm font-semibold text-white">{{ $service['name'] ?? '' }}</p>
                                                <p class="mt-1 text-xs leading-relaxed text-white/60">{{ $service['description'] ?? '' }}</p>
                                                @if (! empty($service['phone']))
                                                    <p class="mt-1 text-xs font-semibold text-gold-300">{{ $service['phone'] }}</p>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="flex flex-col gap-4 rounded-2xl border border-red-400/30 bg-red-500/10 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-red-200">Emergency & support helpline</p>
                                <p class="mt-1 font-numbers text-2xl font-bold text-white">{{ config('portal.drug_helpline') }}</p>
                            </div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('portal.drug_helpline')) }}"
                               class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-gov-950 transition-colors hover:bg-gold-300">
                                <x-icon name="phone" class="size-4" />
                                Call now
                            </a>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('campaign.show', $campaign) }}"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                                Join the campaign
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                            @if ($campaign->videos)
                                <a href="{{ route('campaign.show', $campaign) }}#campaign-videos"
                                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-white/10">
                                    <x-icon name="play" class="size-4" />
                                    Watch videos
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($campaign->stats)
                <dl data-reveal-group class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach ($campaign->stats as $stat)
                        <div data-reveal class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center">
                            <dd class="font-numbers text-2xl font-bold text-gold-300 sm:text-3xl">{{ $stat['value'] }}</dd>
                            <dt class="mt-1 text-xs font-medium uppercase tracking-wider text-white/55">{{ $stat['label'] }}</dt>
                        </div>
                    @endforeach
                </dl>
            @endif
        @endforeach

        {{-- Secondary campaigns --}}
        @if ($otherCampaigns->isNotEmpty())
            <div class="mt-14">
                <h3 class="font-display text-lg font-bold text-white">More campaigns you can join</h3>
                <div data-reveal-group class="mt-6 grid gap-6 md:grid-cols-2">
                    @foreach ($otherCampaigns as $campaign)
                        <a data-reveal
                           href="{{ route('campaign.show', $campaign) }}"
                           class="group relative overflow-hidden rounded-[1.5rem] ring-1 ring-white/10 transition-all duration-300 hover:-translate-y-1 hover:ring-gold-400/40">
                            <x-remote-img
                                src="{{ $campaign->hero_image }}"
                                alt="{{ $campaign->title }}"
                                width="800" height="450"
                                class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                label="Campaign"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-gov-950/95 via-gov-950/40 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-6">
                                <span class="rounded-full bg-white/15 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-widest text-gold-200 backdrop-blur">
                                    {{ $campaign->type->label() }}
                                </span>
                                <h4 class="mt-3 font-display text-xl font-bold text-white">{{ $campaign->title }}</h4>
                                <p class="mt-2 flex items-center gap-2 text-sm font-semibold text-gold-300">
                                    Explore campaign
                                    <x-icon name="arrow-up-right" class="size-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
