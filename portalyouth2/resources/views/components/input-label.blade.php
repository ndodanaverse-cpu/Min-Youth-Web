@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-charcoal-800']) }}>
    {{ $value ?? $slot }}
</label>
