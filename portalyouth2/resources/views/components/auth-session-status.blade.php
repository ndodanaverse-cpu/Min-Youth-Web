@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-gov-700']) }}>
        {{ $status }}
    </div>
@endif
