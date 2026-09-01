@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website',
    'noIndex' => false,
])

@include('layouts.landing', [
    'slot' => $slot,
    'title' => $title,
    'description' => $description,
    'image' => $image,
    'canonical' => $canonical,
    'type' => $type,
    'noIndex' => $noIndex,
])
