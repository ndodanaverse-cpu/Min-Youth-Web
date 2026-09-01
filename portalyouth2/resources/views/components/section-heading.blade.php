@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'dark' => false,
    'class' => '',
    'id' => null,
])

<div
    {{ $attributes->class([
        'max-w-3xl',
        'mx-auto text-center' => $align === 'center',
        'max-w-4xl' => $align === 'center',
        $class,
    ]) }}
    @if ($id) id="{{ $id }}" @endif
>
    @if ($eyebrow)
        <span class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-widest ring-1 {{ $dark ? 'bg-white/10 text-gold-300 ring-white/15' : 'bg-gov-50 text-gov-700 ring-gov-100' }}">
            @if (Str::contains($eyebrow, '·') === false)
                <span class="size-1.5 rounded-full bg-current"></span>
            @endif
            {{ $eyebrow }}
        </span>
    @endif

    @if ($title)
        <h2 class="mt-4 font-display text-3xl font-bold leading-tight tracking-tight text-balance sm:text-4xl lg:text-[2.75rem] {{ $dark ? 'text-white' : 'text-charcoal-900' }}">
            {{ $title }}
        </h2>
    @endif

    @if ($description)
        <p class="mt-4 text-base leading-relaxed sm:text-lg {{ $dark ? 'text-white/70' : 'text-charcoal-600' }}">
            {{ $description }}
        </p>
    @endif
</div>
