<section id="stories" aria-labelledby="stories-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading
            eyebrow="Young voices"
            title="Real stories, real progress"
            description="Young Zimbabweans already building businesses, mastering trades and leading change through our programmes."
            align="center"
        />

        <div data-reveal-group class="mt-14 grid gap-6 md:grid-cols-2">
            @forelse ($stories as $story)
                <figure data-reveal class="flex flex-col justify-between gap-6 rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft sm:flex-row sm:items-start sm:gap-8">
                    <blockquote class="flex-1">
                        <x-icon name="chat-bubble" class="size-6 text-gold-500" />
                        <p class="mt-4 text-base leading-relaxed text-charcoal-700">"{{ $story->testimonial }}"</p>
                        <figcaption class="mt-5 flex items-center gap-3">
                            <span class="inline-flex size-11 items-center justify-center rounded-full bg-gov-700 font-display text-sm font-bold text-white">
                                {{ Str::of($story->name)->trim()->substr(0, 1)->upper() }}
                            </span>
                            <div>
                                <p class="text-sm font-bold text-charcoal-900">{{ $story->name }}{{ $story->age ? ', '.$story->age : '' }}</p>
                                <p class="text-xs text-charcoal-500">{{ $story->role }}{{ $story->province ? ' · '.$story->province->name : '' }}</p>
                            </div>
                        </figcaption>
                    </blockquote>
                    <div class="flex items-center gap-1 text-gold-500" aria-label="5 star success story">
                        @for ($i = 0; $i < 5; $i++)
                            <x-icon name="star" class="size-4" />
                        @endfor
                    </div>
                </figure>
            @empty
                <div class="md:col-span-2">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>
    </div>
</section>
