<section id="news" aria-labelledby="news-heading" class="scroll-mt-section py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <x-section-heading
                eyebrow="Stay informed"
                title="Latest from the Ministry"
                description="News, announcements and updates from the Ministry of Youth Empowerment, Development and Vocational Training."
            />
            @if ($newsItems->isNotEmpty())
                <a href="#news"
                   class="inline-flex shrink-0 items-center gap-2 rounded-full border border-charcoal-200 px-5 py-3 text-sm font-semibold text-gov-700 transition-colors hover:border-gov-700 hover:bg-gov-700 hover:text-white">
                    All news
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            @endif
        </div>

        <div data-reveal-group class="mt-12 grid gap-6 md:grid-cols-3">
            @forelse ($newsItems as $item)
                <article data-reveal class="group flex flex-col overflow-hidden rounded-[1.5rem] border border-charcoal-100 bg-white shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-lift">
                    <div class="h-44 overflow-hidden">
                        <x-remote-img
                            src="{{ $item->cover_image }}"
                            alt="{{ $item->title }}"
                            width="640" height="352"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            label="News"
                        />
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gov-600">
                            {{ $item->published_at?->format('d M Y') }}
                        </p>
                        <h3 class="mt-2 font-display text-base font-bold leading-snug text-charcoal-900">
                            <a href="{{ route('news.show', $item) }}" class="focus:rounded focus:outline-none focus:ring-2 focus:ring-gov-500">
                                {{ $item->title }}
                            </a>
                        </h3>
                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-charcoal-600">{{ $item->summary }}</p>
                        <p class="mt-auto pt-5 flex items-center gap-2 text-sm font-semibold text-gov-700">
                            Read story
                            <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1" />
                        </p>
                    </div>
                </article>
            @empty
                <div class="md:col-span-3">
                    @include('partials.landing.empty-state')
                </div>
            @endforelse
        </div>
    </div>
</section>
