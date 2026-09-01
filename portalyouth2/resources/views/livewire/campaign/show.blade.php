<div>
    {{-- Hero --}}
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <x-remote-img
                src="{{ $campaign->hero_image }}"
                alt=""
                width="1920" height="1080"
                class="h-full w-full object-cover"
                label="Campaign"
            />
            <div class="absolute inset-0 bg-gov-950/80"></div>
        </div>

        <div class="mx-auto max-w-4xl px-4 py-24 text-center sm:px-6 lg:py-32">
            <nav class="mb-8 flex items-center justify-center gap-2 text-xs font-medium text-white/60" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-gold-300">Home</a>
                <x-icon name="chevron-right" class="size-3.5" />
                <a href="{{ route('home').'#campaigns' }}" class="hover:text-gold-300">Campaigns</a>
                <x-icon name="chevron-right" class="size-3.5" />
                <span class="truncate text-white/90" aria-current="page">{{ $campaign->title }}</span>
            </nav>

            <span class="inline-flex items-center gap-2 rounded-full bg-gold-400 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-charcoal-900">
                <x-icon name="megaphone" class="size-4" />
                {{ $campaign->type->label() }}
            </span>
            <h1 class="mt-6 font-display text-3xl font-bold leading-tight text-white text-balance sm:text-4xl lg:text-5xl">{{ $campaign->title }}</h1>
            <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-white/75 sm:text-lg">{{ $campaign->summary }}</p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-12 lg:grid-cols-3">
            {{-- Main --}}
            <div class="lg:col-span-2">
                @if ($campaign->content)
                    <div class="prose prose-gov max-w-none">
                        {!! $campaign->content !!}
                    </div>
                @endif

                @if ($campaign->stats)
                    <dl class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        @foreach ($campaign->stats as $stat)
                            <div class="rounded-2xl border border-charcoal-100 bg-mist-50 p-5 text-center">
                                <dd class="font-numbers text-2xl font-bold text-gov-700 sm:text-3xl">{{ $stat['value'] }}</dd>
                                <dt class="mt-1 text-xs font-medium uppercase tracking-wider text-charcoal-500">{{ $stat['label'] }}</dt>
                            </div>
                        @endforeach
                    </dl>
                @endif

                {{-- Videos --}}
                @if ($campaign->videos)
                    <div id="campaign-videos" class="mt-14 scroll-mt-24">
                        <h2 class="flex items-center gap-2 font-display text-xl font-bold text-charcoal-900">
                            <x-icon name="video-camera" class="size-5 text-gov-600" />
                            Watch & share
                        </h2>
                        <div class="mt-6 grid gap-6 sm:grid-cols-2">
                            @foreach ($campaign->videos as $video)
                                <div class="overflow-hidden rounded-[1.25rem] border border-charcoal-100 bg-white shadow-soft">
                                    @if (! empty($video['url']))
                                        @php
                                            $embed = $video['url'];
                                            if (preg_match('#youtube\.com/watch\?v=([\w-]+)#', $embed, $m)) {
                                                $embed = 'https://www.youtube-nocookie.com/embed/'.$m[1];
                                            } elseif (preg_match('#youtu\.be/([\w-]+)#', $embed, $m)) {
                                                $embed = 'https://www.youtube-nocookie.com/embed/'.$m[1];
                                            }
                                        @endphp
                                        <div class="aspect-video">
                                            <iframe
                                                src="{{ $embed }}"
                                                title="{{ $video['title'] ?? $campaign->title }}"
                                                class="h-full w-full"
                                                loading="lazy"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen
                                            ></iframe>
                                        </div>
                                    @endif
                                    <p class="px-5 py-4 text-sm font-semibold text-charcoal-800">{{ $video['title'] ?? 'Watch' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Support services --}}
                @if ($campaign->support_services)
                    <div class="mt-14">
                        <h2 class="flex items-center gap-2 font-display text-xl font-bold text-charcoal-900">
                            <x-icon name="hand-raised" class="size-5 text-gov-600" />
                            Free support services
                        </h2>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($campaign->support_services as $service)
                                <div class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
                                    <p class="font-display text-base font-semibold text-charcoal-900">{{ $service['name'] ?? '' }}</p>
                                    <p class="mt-2 text-sm leading-relaxed text-charcoal-600">{{ $service['description'] ?? '' }}</p>
                                    @if (! empty($service['phone']))
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $service['phone']) }}" class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-gov-700 hover:text-gov-600">
                                            <x-icon name="phone" class="size-4" />
                                            {{ $service['phone'] }}
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Emergency contacts --}}
                @if ($campaign->emergency_contacts)
                    <div class="mt-10 rounded-[1.5rem] border border-red-200 bg-red-50 p-7">
                        <h2 class="font-display text-lg font-bold text-red-800">In an emergency?</h2>
                        <p class="mt-2 text-sm text-red-700">These lines are available 24/7. You matter — reach out today.</p>
                        <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                            @foreach ($campaign->emergency_contacts as $contact)
                                <li class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-soft">
                                    <span class="text-sm font-semibold text-charcoal-800">{{ $contact['name'] ?? 'Helpline' }}</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact['number'] ?? '') }}"
                                       class="font-numbers text-sm font-bold text-red-700 hover:text-red-600">{{ $contact['number'] ?? '' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24 space-y-5">
                    <div class="rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft">
                        <h2 class="font-display text-sm font-semibold uppercase tracking-widest text-charcoal-500">Get involved</h2>
                        <p class="mt-3 text-sm leading-relaxed text-charcoal-600">Join the movement. Small actions today protect the future of young Zimbabweans.</p>
                        <a href="{{ route('register') }}"
                           class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                            Join the campaign
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                    </div>

                    <div class="rounded-[1.5rem] border border-gov-100 bg-gov-50 p-7">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gov-700">Need help right now?</p>
                        <p class="mt-2 font-numbers text-xl font-bold text-gov-800">{{ config('portal.drug_helpline') }}</p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('portal.drug_helpline')) }}"
                           class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-full bg-gov-700 px-6 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-gov-800">
                            <x-icon name="phone" class="size-4" />
                            Call the helpline
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Related --}}
        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-charcoal-100 pt-12">
                <h2 class="font-display text-xl font-bold text-charcoal-900">More campaigns</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('campaign.show', $item) }}" class="group relative overflow-hidden rounded-[1.25rem] ring-1 ring-charcoal-100">
                            <x-remote-img
                                src="{{ $item->hero_image }}"
                                alt="{{ $item->title }}"
                                width="600" height="340"
                                class="h-44 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                label="Campaign"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-gov-950/90 via-gov-950/30 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <h3 class="font-display text-base font-bold text-white">{{ $item->title }}</h3>
                                <p class="mt-1 text-xs font-semibold text-gold-300">{{ $item->type->label() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
