<div>
    {{-- Breadcrumb --}}
    <div class="border-b border-charcoal-100 bg-mist-50">
        <nav class="mx-auto flex max-w-7xl items-center gap-2 px-4 py-4 text-xs font-medium text-charcoal-500 sm:px-6 lg:px-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-gov-700">Home</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <a href="{{ route('home').'#news' }}" class="hover:text-gov-700">News</a>
            <x-icon name="chevron-right" class="size-3.5" />
            <span class="truncate text-charcoal-900" aria-current="page">{{ $news->title }}</span>
        </nav>
    </div>

    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
        <h1 class="font-display text-3xl font-bold leading-tight tracking-tight text-charcoal-900 sm:text-4xl">{{ $news->title }}</h1>

        <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-charcoal-500">
            @if ($news->author)
                <span class="inline-flex items-center gap-2">
                    <x-icon name="user" class="size-4 text-gov-600" />
                    {{ $news->author }}
                </span>
            @endif
            @if ($news->published_at)
                <span class="inline-flex items-center gap-2">
                    <x-icon name="calendar" class="size-4 text-gov-600" />
                    {{ $news->published_at->format('d M Y') }}
                </span>
            @endif
        </div>

        @if ($news->summary)
            <p class="mt-6 text-lg font-medium leading-relaxed text-charcoal-700">{{ $news->summary }}</p>
        @endif

        @if ($news->cover_image)
            <div class="mt-8 overflow-hidden rounded-[1.5rem]">
                <x-remote-img
                    src="{{ $news->cover_image }}"
                    alt="{{ $news->title }}"
                    width="1200" height="675"
                    class="aspect-video w-full object-cover"
                    label="News"
                />
            </div>
        @endif

        <article class="prose prose-gov mt-10 max-w-none">
            {!! $news->body !!}
        </article>

        <div class="mt-12 flex flex-wrap items-center justify-between gap-4 border-t border-charcoal-100 pt-8">
            @if ($news->source_url)
                <a href="{{ $news->source_url }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-gov-700 hover:text-gov-600">
                    Source: {{ $news->source_name ?: 'External' }}
                    <x-icon name="external-link" class="size-4" />
                </a>
            @endif
            <a href="{{ route('home').'#news' }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gov-700 hover:text-gov-600">
                <x-icon name="chevron-left" class="size-4" />
                All news
            </a>
        </div>
    </div>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <div class="border-t border-charcoal-100 bg-mist-50 py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="font-display text-xl font-bold text-charcoal-900">More from the Ministry</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('news.show', $item) }}" class="group overflow-hidden rounded-[1.25rem] border border-charcoal-100 bg-white shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-lift">
                            <div class="h-40 overflow-hidden">
                                <x-remote-img
                                    src="{{ $item->cover_image }}"
                                    alt="{{ $item->title }}"
                                    width="600" height="320"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    label="News"
                                />
                            </div>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gov-600">{{ $item->published_at?->format('d M Y') }}</p>
                                <h3 class="mt-2 font-display text-base font-bold leading-snug text-charcoal-900 group-hover:text-gov-700">{{ $item->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
