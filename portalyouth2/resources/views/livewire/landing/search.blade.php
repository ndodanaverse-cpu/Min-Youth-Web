<div>
    <section id="search" aria-labelledby="search-heading" class="relative px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl rounded-[2rem] border border-charcoal-100 bg-white p-6 shadow-lift sm:p-8">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-gov-600">Search the portal</p>
                    <h2 id="search-heading" class="mt-2 font-display text-2xl font-bold tracking-tight text-charcoal-900 sm:text-3xl">
                        Find your next opportunity
                    </h2>
                    <p class="mt-1.5 text-sm text-charcoal-600">
                        Search opportunities, programmes, activities and campaigns — type to search live.
                    </p>
                </div>
            </div>

            <form wire:submit="search" class="mt-6 flex flex-col gap-3 sm:flex-row" role="search">
                <label for="site-search" class="sr-only">Search the portal</label>
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-5 inline-flex items-center text-charcoal-400" aria-hidden="true">
                        <x-icon name="magnifying-glass" class="size-5" />
                    </span>
                    <input
                        id="site-search"
                        type="search"
                        wire:model.live.debounce.200ms="q"
                        wire:keydown.escape="clear"
                        placeholder="Try “EmpowerBank”, “vocational training”, “Harare”…"
                        class="w-full rounded-full border-0 bg-mist-50 py-4 pl-13 pr-12 text-base text-charcoal-900 ring-1 ring-charcoal-100 transition placeholder:text-charcoal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gov-600"
                        autocomplete="off"
                    >
                    @if ($this->hasQuery)
                        <button
                            type="button"
                            wire:click="clear"
                            aria-label="Clear search"
                            class="absolute inset-y-0 right-4 inline-flex items-center rounded-full p-1.5 text-charcoal-400 transition-colors hover:bg-charcoal-100 hover:text-charcoal-700"
                        >
                            <x-icon name="x-mark" class="size-4" />
                        </button>
                    @endif
                </div>

                <button
                    type="submit"
                    class="group inline-flex items-center justify-center gap-2 rounded-full bg-gov-700 px-8 py-4 text-base font-semibold text-white shadow-soft transition-all duration-200 hover:-translate-y-0.5 hover:bg-gov-600"
                >
                    Search
                    <x-icon name="arrow-right" class="size-5 transition-transform group-hover:translate-x-1" />
                </button>
            </form>

            <div class="mt-5 flex flex-wrap items-center gap-2" role="group" aria-label="Filter by type">
                @foreach ($this->types as $value => $label)
                    <button
                        type="button"
                        wire:click="$set('type', '{{ $value }}')"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-semibold transition-colors',
                            'bg-gov-700 text-white' => $type === $value,
                            'bg-mist-50 text-charcoal-600 ring-1 ring-charcoal-100 hover:bg-charcoal-100' => $type !== $value,
                        ])
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Live results --}}
            @if ($this->hasQuery)
                <div class="mt-6 divide-y divide-charcoal-100 rounded-2xl border border-charcoal-100 bg-white">
                    @if ($this->resultCount > 0)
                        @foreach ($this->results as $group => $items)
                            <div class="p-4">
                                <p class="px-2 text-[11px] font-semibold uppercase tracking-widest text-charcoal-400">
                                    {{ $group }}
                                </p>
                                <ul class="mt-2">
                                    @foreach ($items as $item)
                                        @php
                                            $route = match ($group) {
                                                'Opportunities' => route('opportunity.show', $item),
                                                'Programmes' => route('programme.show', $item),
                                                'Campaigns' => route('campaign.show', $item),
                                                default => '#activities',
                                            };
                                            $icon = match ($group) {
                                                'Opportunities' => 'briefcase',
                                                'Programmes' => 'graduation-cap',
                                                'Campaigns' => 'megaphone',
                                                default => 'calendar',
                                            };
                                        @endphp
                                        <li>
                                            <a href="{{ $route }}" class="group flex items-start gap-3 rounded-xl px-2 py-3 transition-colors hover:bg-mist-50">
                                                <span class="mt-0.5 inline-flex size-9 shrink-0 items-center justify-center rounded-lg bg-gov-50 text-gov-700">
                                                    <x-icon name="{{ $icon }}" class="size-4" />
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block truncate font-semibold text-charcoal-900 group-hover:text-gov-700">{{ $item->title }}</span>
                                                    <span class="block truncate text-sm text-charcoal-500">{{ $item->summary }}</span>
                                                </span>
                                                <x-icon name="arrow-right" class="ml-auto mt-2 size-4 shrink-0 text-charcoal-300 transition-transform group-hover:translate-x-1 group-hover:text-gov-600" />
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @else
                        <p class="px-6 py-10 text-center text-sm text-charcoal-500">
                            No {{ $type !== 'all' ? $this->types[$type] : '' }} match “{{ $q }}”.
                            Try a different keyword.
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </section>
</div>
