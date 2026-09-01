<section id="join" aria-labelledby="join-heading" class="relative overflow-hidden bg-gov-800 py-20 lg:py-24">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -right-32 -top-32 size-96 rounded-full bg-gold-400/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 size-80 rounded-full bg-gov-600 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
        <h2 id="join-heading" data-reveal class="font-display text-3xl font-bold leading-tight text-white text-balance sm:text-4xl lg:text-5xl">
            Your future starts today.<br>
            <span class="text-gold-300">Join {{ config('portal.name') }} free.</span>
        </h2>
        <p data-reveal class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-white/70 sm:text-lg">
            Create a profile, get verified, and unlock programmes, funding and opportunities
            tailored to you — anywhere in Zimbabwe.
        </p>

        <div data-reveal class="mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-3 rounded-full bg-gold-400 px-8 py-4 text-base font-semibold text-charcoal-900 shadow-lift transition-all duration-200 hover:-translate-y-0.5 hover:bg-gold-300">
                Create my account
                <x-icon name="arrow-right" class="size-5" />
            </a>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-3 rounded-full border border-white/25 px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-white/10">
                Already registered? Sign in
            </a>
        </div>

        <p data-reveal class="mt-6 text-xs font-medium uppercase tracking-widest text-white/40">
            Free forever · No hidden costs · Your data is protected
        </p>
    </div>
</section>
