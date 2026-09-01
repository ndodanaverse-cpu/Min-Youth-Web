@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website',
    'noIndex' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/webp" href="{{ asset('logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.webp') }}">

    <x-seo
        :title="$title"
        :description="$description"
        :image="$image"
        :canonical="$canonical"
        :type="$type"
        :no-index="$noIndex"
    />

    <x-json-ld :data="[
        '@context' => 'https://schema.org',
        '@type' => 'GovernmentOrganization',
        'name' => config('portal.ministry'),
        'alternateName' => config('portal.name'),
        'url' => url('/'),
        'logo' => asset('logo.webp'),
        'email' => config('portal.email'),
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Kwame Nkrumah & Third St', 'addressLocality' => 'Harare', 'addressCountry' => 'ZW'],
        'sameAs' => array_values(array_filter(config('portal.social'))),
    ]" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <script>
        document.documentElement.classList.add('js');
    </script>
    <noscript>
        <style>
            [data-reveal], [data-reveal-group] [data-reveal] { opacity: 1 !important; transform: none !important; }
        </style>
    </noscript>

    @stack('head')
</head>
<body class="min-h-screen bg-white font-sans text-charcoal-900">
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-xl focus:bg-gov-700 focus:px-5 focus:py-3 focus:font-semibold focus:text-white">
        Skip to main content
    </a>

    @include('partials.landing.nav')

    <main id="main-content">
        {{ $slot }}
    </main>

    @include('partials.landing.footer')

    @stack('footer')
    @livewireScripts
</body>
</html>
