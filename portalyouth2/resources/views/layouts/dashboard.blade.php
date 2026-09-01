@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/webp" href="{{ asset('logo.webp') }}">

    <x-seo
        :title="$title"
        :no-index="true"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-mist-50 font-sans text-charcoal-900 antialiased">
    <div x-data="{ open: false }" class="min-h-screen lg:flex">
        {{-- Mobile overlay --}}
        <div x-show="open" x-cloak
             @click="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-40 bg-charcoal-950/60 lg:hidden" aria-hidden="true"></div>

        {{-- Sidebar --}}
        <aside x-show="open" x-cloak
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-gov-950 text-white lg:static lg:translate-x-0 lg:transition-none"
               aria-label="Dashboard navigation">
            <div class="flex h-20 items-center justify-between px-6">
                <a href="{{ route('home') }}" class="font-display text-lg font-bold text-white">
                    {{ config('portal.name') }}
                </a>
                <button type="button" @click="open = false" class="rounded-lg p-1.5 text-white/60 hover:bg-white/10 lg:hidden" aria-label="Close menu">
                    <x-icon name="x-mark" class="size-5" />
                </button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-4">
                @php
                    $nav = [
                        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Overview'],
                        ['route' => 'dashboard.profile', 'icon' => 'user', 'label' => 'My profile'],
                        ['route' => 'dashboard.opportunities', 'icon' => 'briefcase', 'label' => 'Opportunities'],
                        ['route' => 'dashboard.applications', 'icon' => 'clipboard', 'label' => 'My applications'],
                        ['route' => 'dashboard.notifications', 'icon' => 'bell', 'label' => 'Notifications'],
                    ];
                @endphp
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       @class([
                           'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors',
                           'bg-gold-400 text-charcoal-900' => request()->routeIs($item['route']),
                           'text-white/70 hover:bg-white/10 hover:text-white' => ! request()->routeIs($item['route']),
                       ])>
                        <x-icon name="{{ $item['icon'] }}" class="size-5" />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="space-y-3 border-t border-white/10 p-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-white/70 transition-colors hover:bg-white/10 hover:text-white">
                    <x-icon name="globe" class="size-5" />
                    Back to portal
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-semibold text-white/70 transition-colors hover:bg-white/10 hover:text-white">
                        <x-icon name="arrow-right" class="size-5 -scale-x-100" />
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-20 items-center justify-between border-b border-charcoal-100 bg-white px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button type="button" @click="open = true" class="rounded-lg p-1.5 text-charcoal-600 hover:bg-mist-100 lg:hidden" aria-label="Open menu">
                        <x-icon name="menu" class="size-6" />
                    </button>
                    <h1 class="font-display text-lg font-bold text-charcoal-900 sm:text-xl">{{ $title }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard.notifications') }}" class="relative rounded-lg p-2 text-charcoal-500 hover:bg-mist-100" aria-label="Notifications">
                        <x-icon name="bell" class="size-5" />
                        @if (auth()->user()->unreadNotifications->isNotEmpty())
                            <span class="absolute right-1 top-1 size-2.5 rounded-full bg-red-500"></span>
                        @endif
                    </a>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex size-10 items-center justify-center rounded-full bg-gov-700 font-display text-sm font-bold text-white">
                            {{ Str::of(auth()->user()->name)->trim()->substr(0, 1)->upper() }}
                        </span>
                        <div class="hidden sm:block">
                            <p class="text-sm font-bold text-charcoal-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-charcoal-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <footer class="border-t border-charcoal-100 bg-white px-4 py-5 text-center text-xs text-charcoal-500 sm:px-6 lg:px-8">
                © {{ date('Y') }} {{ config('portal.ministry') }} · {{ config('portal.name') }}
            </footer>
        </div>
    </div>

    @livewireScripts
</body>
</html>
