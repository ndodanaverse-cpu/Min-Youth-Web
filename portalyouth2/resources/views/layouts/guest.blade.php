<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative min-h-screen bg-gov-950 font-sans text-charcoal-900 antialiased">
        {{-- Geometric background --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -top-40 -right-40 size-[34rem] rounded-full bg-gov-700/30 blur-3xl"></div>
            <div class="absolute bottom-0 -left-40 size-[30rem] rounded-full bg-gold-500/10 blur-3xl"></div>
            <svg class="absolute inset-0 h-full w-full text-white/[0.04]" width="100%" height="100%">
                <defs>
                    <pattern id="authgrid" width="72" height="72" patternUnits="userSpaceOnUse">
                        <path d="M36 8 64 36 36 64 8 36Z" fill="none" stroke="currentColor" stroke-width="1"/>
                        <circle cx="36" cy="36" r="2.5" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#authgrid)"/>
            </svg>
        </div>

        <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6">
            {{-- Brand header --}}
            <a href="{{ route('home') }}" class="mb-8 inline-flex items-center" aria-label="{{ config('portal.name') }} — home">
                <img src="{{ asset('logo.png') }}" alt="{{ config('portal.name') }}" width="759" height="184" class="h-14 w-auto rounded-2xl bg-white px-3 py-2 object-contain shadow-soft ring-1 ring-black/5">
            </a>

            {{-- Card --}}
            <div class="w-full max-w-md overflow-hidden rounded-[1.75rem] border border-charcoal-100 bg-white shadow-lift">
                <div class="h-1.5 w-full bg-gradient-to-r from-gov-600 via-gold-400 to-gov-600"></div>
                <div class="p-8 sm:p-10">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-8 text-center text-xs leading-relaxed text-white/40">
                {{ config('portal.ministry') }} · Built by
                <a href="https://www.blacklemur.co.zw" target="_blank" rel="noopener noreferrer" class="font-semibold text-gold-300/70 transition-colors hover:text-gold-300">
                    Blacklemur Innovations
                </a>
            </p>
        </div>
    </body>
</html>
