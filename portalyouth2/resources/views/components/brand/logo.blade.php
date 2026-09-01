@props([
    'class' => '',
])

<a href="{{ route('home') }}" class="inline-flex items-center {{ $class }}" aria-label="{{ config('portal.name') }} — home">
    <img
        src="{{ asset('logo.png') }}"
        alt="{{ config('portal.name') }}"
        width="759"
        height="184"
        class="h-10 w-auto rounded-xl bg-white px-2 py-1.5 object-contain shadow-soft ring-1 ring-black/5"
    >
</a>
