@php
    $user = auth()->user();
    $links = [
        ['label' => 'Home', 'href' => '#home'],
        ['label' => 'Programmes', 'href' => '#programmes'],
        ['label' => 'Opportunities', 'href' => '#opportunities'],
        ['label' => 'Campaigns', 'href' => '#campaigns'],
        ['label' => 'About', 'href' => '#about'],
    ];
@endphp

<header
    x-data="{ scrolled: false, open: false, lockScroll() { document.body.style.overflow = this.open ? 'hidden' : ''; } }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 24; }, { passive: true }); $watch('open', () => lockScroll()); window.addEventListener('keydown', (e) => { if (e.key === 'Escape') open = false; });"
    x-bind:class="scrolled ? 'bg-white/95 shadow-soft backdrop-blur-md' : 'bg-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :aria-label="'Main navigation'"
>
    <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Primary">
        <x-brand.logo />

        <div class="hidden items-center gap-1 lg:flex" aria-label="Sections">
            @foreach ($links as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="rounded-full px-4 py-2 text-sm font-semibold transition-colors {{ $user ? '' : '' }}"
                    :class="scrolled ? 'text-charcoal-700 hover:bg-gov-50 hover:text-gov-700' : 'text-white/85 hover:bg-white/10 hover:text-white'"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            <form method="POST" action="{{ route('locale.update') }}">
                @csrf
                <label class="sr-only" for="portal-language">Language</label>
                <select id="portal-language" name="locale" onchange="this.form.submit()"
                        class="rounded-full border-0 bg-white/10 px-3 py-2 text-sm font-semibold text-white outline-none transition-colors scrolled:text-charcoal-800">
                    @foreach (config('portal.translation_locales', []) as $locale)
                        <option value="{{ $locale }}" @selected(app()->getLocale() === $locale) class="text-charcoal-900">
                            {{ strtoupper($locale) }}
                        </option>
                    @endforeach
                </select>
            </form>
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5"
                    :class="scrolled ? 'bg-gov-50 text-gov-700 hover:bg-gov-100' : 'bg-white/10 text-white hover:bg-white/20'"
                >
                    <x-icon name="user" class="size-4" />
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="rounded-full px-5 py-2.5 text-sm font-semibold transition-all duration-200"
                    :class="scrolled ? 'text-charcoal-700 hover:bg-gov-50 hover:text-gov-700' : 'text-white/90 hover:bg-white/10'"
                >
                    Sign In
                </a>
                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-gold-400 px-6 py-2.5 text-sm font-semibold text-charcoal-900 shadow-soft transition-all duration-200 hover:-translate-y-0.5 hover:bg-gold-300"
                >
                    Register
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            @endauth
        </div>

        <button
            type="button"
            class="inline-flex size-11 items-center justify-center rounded-xl text-charcoal-900 ring-1 ring-black/10 transition-colors lg:hidden"
            :class="scrolled ? 'bg-white text-charcoal-900' : 'bg-white/10 text-white ring-white/20'"
            x-on:click="open = !open"
            :aria-expanded="open"
            aria-controls="mobile-menu"
            :aria-label="open ? 'Close menu' : 'Open menu'"
        >
            <template x-if="!open">
                <x-icon name="menu" class="size-6" />
            </template>
            <template x-if="open">
                <x-icon name="x-mark" class="size-6" />
            </template>
        </button>
    </nav>

    {{-- Mobile drawer --}}
    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-150 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        id="mobile-menu"
        role="dialog"
        aria-modal="true"
        aria-label="Menu"
        class="absolute inset-x-0 top-20 border-t border-charcoal-100 bg-white/98 shadow-lift backdrop-blur-xl lg:hidden"
    >
        <nav class="space-y-1 px-4 py-6" aria-label="Mobile">
            @foreach ($links as $link)
                <a
                    href="{{ $link['href'] }}"
                    x-on:click="open = false"
                    class="flex items-center justify-between rounded-2xl px-4 py-3.5 text-base font-semibold text-charcoal-800 transition-colors hover:bg-gov-50 hover:text-gov-700"
                >
                    {{ $link['label'] }}
                    <x-icon name="chevron-right" class="size-5 text-charcoal-300" />
                </a>
            @endforeach

            <div class="mt-4 grid gap-3 border-t border-charcoal-100 pt-6">
                <form method="POST" action="{{ route('locale.update') }}">
                    @csrf
                    <label class="mb-2 block text-sm font-semibold text-charcoal-700" for="portal-language-mobile">Language</label>
                    <select id="portal-language-mobile" name="locale" onchange="this.form.submit()"
                            class="w-full rounded-xl border border-charcoal-200 bg-white px-4 py-3 text-sm font-semibold text-charcoal-800">
                        @foreach (config('portal.translation_locales', []) as $locale)
                            <option value="{{ $locale }}" @selected(app()->getLocale() === $locale)>{{ strtoupper($locale) }}</option>
                        @endforeach
                    </select>
                </form>
                @auth
                    <a href="{{ route('dashboard') }}" x-on:click="open = false"
                       class="inline-flex items-center justify-center gap-2 rounded-full bg-gov-700 px-6 py-3.5 text-sm font-semibold text-white">
                        <x-icon name="user" class="size-4" />
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" x-on:click="open = false"
                       class="inline-flex items-center justify-center rounded-full px-6 py-3.5 text-sm font-semibold text-charcoal-800 ring-1 ring-charcoal-200 transition-colors hover:bg-charcoal-50">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" x-on:click="open = false"
                       class="inline-flex items-center justify-center gap-2 rounded-full bg-gold-400 px-6 py-3.5 text-sm font-semibold text-charcoal-900 shadow-soft">
                        Register Now
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>

{{-- Mobile sticky register CTA --}}
@guest
<div
    x-data="{ visible: false }"
    x-init="window.addEventListener('scroll', () => { visible = window.scrollY > 640; }, { passive: true })"
    x-show="visible"
    x-cloak
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="opacity-0 translate-y-full"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-full"
    class="fixed inset-x-0 bottom-4 z-40 px-4 lg:hidden"
>
    <a href="{{ route('register') }}"
       class="flex items-center justify-between gap-3 rounded-full bg-charcoal-900 px-6 py-4 font-semibold text-white shadow-lift ring-1 ring-white/10">
        <span>Join the national youth portal</span>
        <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-full bg-gold-400 text-charcoal-900">
            <x-icon name="arrow-right" class="size-5" />
        </span>
    </a>
</div>
@endguest
