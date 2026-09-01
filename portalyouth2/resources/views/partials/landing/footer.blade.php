<footer class="bg-gov-950 text-white" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-8">
            {{-- Brand + newsletter --}}
            <div class="lg:col-span-4">
                <x-brand.logo />
                <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/65">
                    {{ config('portal.ministry') }} — empowering young Zimbabweans to build skills,
                    grow businesses and shape the nation's future.
                </p>

                <div class="mt-8">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">
                        Get updates
                    </h3>
                    <p class="mt-2 text-sm text-white/55">Youth news, funding calls and opportunities — straight to your inbox.</p>
                    <div class="mt-4">
                        <livewire:components.newsletter-subscribe />
                    </div>
                </div>
            </div>

            {{-- Quick links --}}
            <nav class="lg:col-span-2" aria-label="Quick links">
                <h3 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">Quick Links</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-white/70 transition-colors hover:text-gold-300">Home</a></li>
                    <li><a href="#programmes" class="text-white/70 transition-colors hover:text-gold-300">Programmes</a></li>
                    <li><a href="#opportunities" class="text-white/70 transition-colors hover:text-gold-300">Opportunities</a></li>
                    <li><a href="#campaigns" class="text-white/70 transition-colors hover:text-gold-300">Campaigns</a></li>
                    <li><a href="#about" class="text-white/70 transition-colors hover:text-gold-300">About</a></li>
                </ul>
            </nav>

            {{-- Resources & downloads --}}
            <nav class="lg:col-span-2" aria-label="Resources">
                <h3 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">Resources</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach (config('portal.related_links') as $link)
                        <li>
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-white/70 transition-colors hover:text-gold-300">
                                {{ $link['label'] }}
                                <x-icon name="external-link" class="size-3.5" />
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('privacy') }}" class="text-white/70 transition-colors hover:text-gold-300">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="text-white/70 transition-colors hover:text-gold-300">Terms of Use</a>
                    </li>
                </ul>
            </nav>

            {{-- Contact --}}
            <div class="lg:col-span-4">
                <h3 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">Contact</h3>
                <address class="mt-5 space-y-4 text-sm not-italic">
                    <p class="flex items-start gap-3 text-white/70">
                        <x-icon name="location" class="mt-0.5 size-5 shrink-0 text-gold-400" />
                        {{ config('portal.address') }}
                    </p>
                    <p>
                        <a href="mailto:{{ config('portal.email') }}" class="flex items-center gap-3 text-white/70 transition-colors hover:text-gold-300">
                            <x-icon name="envelope" class="size-5 shrink-0 text-gold-400" />
                            {{ config('portal.email') }}
                        </a>
                    </p>
                    @foreach (config('portal.phones') as $phone)
                        <p>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="flex items-center gap-3 text-white/70 transition-colors hover:text-gold-300">
                                <x-icon name="phone" class="size-5 shrink-0 text-gold-400" />
                                {{ $phone }}
                            </a>
                        </p>
                    @endforeach
                </address>

                <div class="mt-7">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-widest text-gold-300">Follow us</h3>
                    <ul class="mt-4 flex gap-3">
                        @foreach (config('portal.social') as $network => $url)
                            @if ($url)
                                <li>
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex size-10 items-center justify-center rounded-full bg-white/5 ring-1 ring-white/10 transition-colors hover:bg-gold-400 hover:text-charcoal-900"
                                       aria-label="Follow us on {{ ucfirst($network) }}">
                                        <x-icon name="{{ match ($network) { 'twitter' => 'external-link', 'facebook' => 'external-link', 'youtube' => 'video-camera', default => 'external-link' } }}" class="size-5" />
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-16 flex flex-col items-start justify-between gap-4 border-t border-white/10 pt-8 sm:flex-row sm:items-center">
            <p class="text-xs text-white/50">
                © {{ date('Y') }} {{ config('portal.ministry') }}. All rights reserved.
            </p>
            <p class="text-xs text-white/50">
                Empowering the <span class="font-semibold text-gold-300">demographic dividend</span> · Vision 2030
            </p>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-6">
            <p class="text-xs text-white/40">
                Youth Portal Zimbabwe — <span class="text-gold-300/70">Version 1.0</span> · Built by
                <a href="https://www.blacklemur.co.zw" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-300/70 transition-colors hover:text-gold-300">Blacklemur Innovations</a>
            </p>
            <p class="text-xs text-white/40">
                National Youth Help &amp; Drug Abuse Hotline:
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('portal.drug_helpline')) }}" class="font-semibold text-gold-300/70 transition-colors hover:text-gold-300">{{ config('portal.drug_helpline') }}</a>
            </p>
        </div>
    </div>
</footer>
