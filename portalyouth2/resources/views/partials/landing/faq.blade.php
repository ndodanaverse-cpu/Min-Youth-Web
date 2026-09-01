<section id="faq" aria-labelledby="faq-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="Questions?"
            title="Frequently asked questions"
            description="Everything young people ask us about joining programmes, applying and getting support."
            align="center"
        />

        <div class="mt-12 space-y-3">
            @forelse ($faqs as $index => $faq)
                <div
                    data-reveal
                    x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
                    class="overflow-hidden rounded-2xl border border-charcoal-100 bg-white shadow-soft"
                >
                    <button
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        aria-controls="faq-{{ $faq->getKey() }}-panel"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left"
                    >
                        <span class="font-display text-base font-semibold text-charcoal-900">{{ $faq->question }}</span>
                        <x-icon name="chevron-down"
                                class="size-5 shrink-0 text-gov-600 transition-transform duration-300"
                                x-bind:class="{ 'rotate-180': open }"
                                aria-hidden="true" />
                    </button>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-collapse
                        id="faq-{{ $faq->getKey() }}-panel"
                    >
                        <p class="px-6 pb-6 text-sm leading-relaxed text-charcoal-600">{{ $faq->answer }}</p>
                    </div>
                </div>
            @empty
                <div class="flex justify-center">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>

        <p data-reveal class="mt-10 text-center text-sm text-charcoal-600">
            Still have questions?
            <a href="mailto:{{ config('portal.email') }}" class="font-semibold text-gov-700 underline-offset-4 hover:underline">
                {{ config('portal.email') }}
            </a>
        </p>
    </div>
</section>
