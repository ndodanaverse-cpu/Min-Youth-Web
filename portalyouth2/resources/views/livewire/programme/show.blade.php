<div>
    {{-- Breadcrumb --}}
    <div class="border-b border-charcoal-100 bg-mist-50">
        <nav class="mx-auto flex max-w-7xl items-center gap-2 px-4 py-4 text-xs font-medium text-charcoal-500 sm:px-6 lg:px-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-gov-700">Home</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <a href="{{ route('home').'#programmes' }}" class="hover:text-gov-700">Programmes</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <span class="truncate text-charcoal-900" aria-current="page">{{ $programme->title }}</span>
        </nav>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-12 lg:grid-cols-3">
            {{-- Main --}}
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex size-12 items-center justify-center rounded-2xl bg-gov-700 text-white">
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
                    <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-semibold text-gold-800">{{ $programme->category->label() }}</span>
                </div>

                <h1 class="mt-4 font-display text-3xl font-bold leading-tight tracking-tight text-charcoal-900 sm:text-4xl">{{ $programme->title }}</h1>
                <p class="mt-4 text-lg leading-relaxed text-charcoal-600">{{ $programme->summary }}</p>

                @if ($programme->image_url)
                    <div class="mt-8 overflow-hidden rounded-[1.5rem]">
                        <x-remote-img
                            src="{{ $programme->image_url }}"
                            alt="{{ $programme->title }}"
                            width="1200" height="675"
                            class="aspect-video w-full object-cover"
                            label="Programme"
                        />
                    </div>
                @endif

                <div class="prose prose-gov mt-10 max-w-none">
                    {!! $programme->description !!}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24 space-y-5">
                    <div class="rounded-[1.5rem] border border-charcoal-100 bg-white p-7 shadow-soft">
                        <h2 class="font-display text-sm font-semibold uppercase tracking-widest text-charcoal-500">Get involved</h2>
                        <p class="mt-3 text-sm leading-relaxed text-charcoal-600">Create a free account to register your interest and be the first to hear about opportunities under this programme.</p>
                        <a href="{{ route('register') }}"
                           class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                            Register interest
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                        <p class="mt-3 text-center text-xs text-charcoal-500">Open to ages 15–35</p>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Success stories --}}
        @if ($stories->isNotEmpty())
            <div class="mt-16 border-t border-charcoal-100 pt-12">
                <h2 class="font-display text-xl font-bold text-charcoal-900">Success stories from this programme</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($stories as $story)
                        <figure class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
                            <blockquote>
                                <p class="text-sm leading-relaxed text-charcoal-600">"{{ $story->testimonial }}"</p>
                            </blockquote>
                            <figcaption class="mt-4 flex items-center gap-3">
                                <span class="inline-flex size-10 items-center justify-center rounded-full bg-gov-700 font-display text-sm font-bold text-white">
                                    {{ Str::of($story->name)->trim()->substr(0, 1)->upper() }}
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-charcoal-900">{{ $story->name }}{{ $story->age ? ', '.$story->age : '' }}</p>
                                    <p class="text-xs text-charcoal-500">{{ $story->role }}</p>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Related --}}
        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-charcoal-100 pt-12">
                <h2 class="font-display text-xl font-bold text-charcoal-900">Explore more programmes</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('programme.show', $item) }}" class="group rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-lift">
                            <span class="text-xs font-semibold uppercase tracking-widest text-gov-600">{{ $item->category->label() }}</span>
                            <h3 class="mt-2 font-display text-base font-bold leading-snug text-charcoal-900 group-hover:text-gov-700">{{ $item->title }}</h3>
                            <p class="mt-3 line-clamp-2 text-sm text-charcoal-600">{{ $item->summary }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
