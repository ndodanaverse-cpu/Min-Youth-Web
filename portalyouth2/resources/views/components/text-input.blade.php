@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-charcoal-200 focus:border-gov-500 focus:ring-gov-500 rounded-xl shadow-sm']) }}>
