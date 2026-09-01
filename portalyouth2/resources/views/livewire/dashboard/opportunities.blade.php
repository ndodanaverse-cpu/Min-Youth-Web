<div class="mx-auto max-w-5xl">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="font-display text-lg font-bold text-charcoal-900">Open opportunities</h2>
            <p class="mt-1 text-sm text-charcoal-500">Save opportunities to apply to later, or apply straight away.</p>
        </div>
    </div>

    @if ($opportunities->isEmpty())
        <div class="mt-6 flex flex-col items-center rounded-[1.25rem] border border-dashed border-charcoal-200 bg-white px-6 py-16 text-center">
            <x-icon name="briefcase" class="size-8 text-charcoal-300" />
            <p class="mt-3 text-sm text-charcoal-600">No open opportunities right now. Check back soon.</p>
        </div>
    @else
        <ul class="mt-6 space-y-4">
            @foreach ($opportunities as $opportunity)
                <li class="rounded-[1.25rem] border border-charcoal-100 bg-white p-6 shadow-soft">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-gov-100 px-2.5 py-0.5 text-xs font-semibold text-gov-800">{{ $opportunity->category->label() }}</span>
                                @if ($opportunity->province)
                                    <span class="text-xs font-medium text-charcoal-500">{{ $opportunity->province->name }}</span>
                                @endif
                            </div>
                            <a href="{{ route('opportunity.show', $opportunity) }}" class="mt-2 block font-display text-base font-bold text-charcoal-900 hover:text-gov-700">
                                {{ $opportunity->title }}
                            </a>
                            <p class="mt-2 line-clamp-2 text-sm text-charcoal-600">{{ $opportunity->summary }}</p>
                            <p class="mt-3 text-xs font-medium text-charcoal-500">
                                @if ($opportunity->deadline_at)
                                    Deadline: {{ $opportunity->deadline_at->format('d M Y') }}
                                @else
                                    Rolling deadline
                                @endif
                            </p>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            <button
                                type="button"
                                wire:click="toggleSave('{{ $opportunity->id }}')"
                                wire:loading.attr="disabled"
                                @class([
                                    'inline-flex items-center gap-1.5 rounded-full border px-4 py-2 text-xs font-semibold transition-colors',
                                    'border-gold-400 bg-gold-50 text-gold-800 hover:bg-gold-100' => in_array((string) $opportunity->id, $saved, true),
                                    'border-charcoal-200 text-charcoal-600 hover:border-gold-300 hover:text-gold-800' => ! in_array((string) $opportunity->id, $saved, true),
                                ])>
                                <x-icon name="star" class="size-4" />
                                {{ in_array((string) $opportunity->id, $saved, true) ? 'Saved' : 'Save' }}
                            </button>
                            <a href="{{ route('opportunity.show', $opportunity) }}"
                               class="inline-flex items-center gap-1.5 rounded-full bg-gov-700 px-4 py-2 text-xs font-semibold text-white transition-colors hover:bg-gov-800">
                                Apply
                                <x-icon name="arrow-right" class="size-4" />
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
