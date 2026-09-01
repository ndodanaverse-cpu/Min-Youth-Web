<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 bg-gold-400 border border-transparent rounded-full px-6 py-3 font-semibold text-sm text-charcoal-900 shadow-soft hover:bg-gold-300 focus:bg-gold-300 active:bg-gold-500 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
