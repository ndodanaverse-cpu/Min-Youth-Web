<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Page not found · {{ config('portal.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gov-950 px-6 font-sans text-white antialiased">
    <div class="w-full max-w-xl text-center">
        <div class="mx-auto inline-flex size-20 items-center justify-center rounded-3xl bg-white/5 ring-1 ring-white/10">
            <x-icon name="magnifying-glass" class="size-9 text-gold-400" />
        </div>
        <p class="mt-8 font-numbers text-6xl font-bold text-gold-400">404</p>
        <h1 class="mt-3 font-display text-2xl font-bold text-balance sm:text-3xl">This page has drifted out of sight</h1>
        <p class="mx-auto mt-4 max-w-md text-sm leading-relaxed text-white/65 sm:text-base">
            The page you're looking for may have moved or no longer exists.
            Let's get you back to what matters — your future.
        </p>
        <a href="{{ route('home') }}"
           class="mt-8 inline-flex items-center justify-center gap-2 rounded-full bg-gold-400 px-7 py-3.5 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
            Back to the portal
            <x-icon name="arrow-right" class="size-4" />
        </a>
    </div>
</body>
</html>
