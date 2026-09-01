@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website',
    'noIndex' => false,
])

@php
    $siteName = config('portal.name');
    $siteDescription = setting('seo.description') ?? 'The official portal connecting Zimbabwean youth aged 15–35 to national programmes, opportunities, activities and campaigns.';

    $pageTitle = $title
        ? ($title.' | '.$siteName)
        : $siteName.' — '.config('portal.ministry');

    $pageDescription = $description ?? $siteDescription;

    $pageImage = $image
        ? remote_image($image)
        : asset('logo.webp');

    $pageUrl = $canonical ?? url()->current();
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
@if ($noIndex)
    <meta name="robots" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
@endif
<link rel="canonical" href="{{ $pageUrl }}">

<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title ? $title.' | '.$siteName : $siteName }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageUrl }}">
@if ($pageImage)
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endif
<meta property="og:locale" content="en_ZW">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ? $title.' | '.$siteName : $siteName }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
@if ($pageImage)
    <meta name="twitter:image" content="{{ $pageImage }}">
@endif

<meta name="theme-color" content="#1c6547">
