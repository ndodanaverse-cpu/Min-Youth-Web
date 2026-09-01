@props([
    'src' => null,
    'alt' => '',
    'width' => null,
    'height' => null,
    'eager' => false,
    'class' => '',
    'sizes' => null,
    'label' => 'Zimbabwe Youth',
])

@php
    $isLocal = is_string($src) && str_starts_with($src, '/');
    $proxied = $isLocal ? $src : remote_image($src);
    $placeholder = \App\Support\RemoteImage::placeholderDataUri($label);
    $ratioStyle = $width && $height ? "aspect-ratio: {$width} / {$height};" : '';
@endphp

<img
    src="{{ $proxied ?? $placeholder }}"
    alt="{{ $alt }}"
    @if ($width) width="{{ $width }}" @endif
    @if ($height) height="{{ $height }}" @endif
    @if (! $eager) loading="lazy" decoding="async" @endif
    @if ($sizes) sizes="{{ $sizes }}" @endif
    onerror="this.onerror=null;this.src='{{ $placeholder }}';"
    class="{{ $class }}"
    style="{{ $ratioStyle }}"
>
