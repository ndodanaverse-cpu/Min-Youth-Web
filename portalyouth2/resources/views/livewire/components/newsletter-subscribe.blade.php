<div>
    @if ($subscribed)
        <div class="flex items-center gap-3 rounded-2xl border border-gov-200 bg-gov-50 p-4 text-sm font-medium text-gov-800">
            <x-icon name="check-circle" class="size-5 shrink-0 text-gov-600" />
            <span>You're in! Watch your inbox for youth news and opportunities.</span>
        </div>
    @else
        <form wire:submit="subscribe" class="space-y-3" role="form" aria-label="Newsletter subscription">
            <label for="newsletter-first-name" class="sr-only">First name</label>
            <input
                id="newsletter-first-name"
                type="text"
                wire:model="first_name"
                placeholder="First name (optional)"
                autocomplete="given-name"
                class="w-full rounded-xl border-charcoal-200 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-gold-400 focus:ring-gold-400"
            >
            <label for="newsletter-email" class="sr-only">Email address</label>
            <input
                id="newsletter-email"
                type="email"
                wire:model="email"
                placeholder="you@example.com"
                autocomplete="email"
                class="w-full rounded-xl border-charcoal-200 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-gold-400 focus:ring-gold-400"
            >
            @error('email')
                <p class="text-xs font-medium text-gold-300" role="alert">{{ $message }}</p>
            @enderror
            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gold-400 px-5 py-3 text-sm font-semibold text-charcoal-900 transition-colors hover:bg-gold-300">
                Subscribe
                <x-icon name="envelope" class="size-4" />
            </button>
        </form>
    @endif
</div>
