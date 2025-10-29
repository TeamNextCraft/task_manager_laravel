@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-3 rounded-xl text-base font-semibold bg-white text-emerald-700 shadow-lg border-2 border-white transition-all duration-300 ease-out transform focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600'
            : 'inline-flex items-center px-4 py-3 rounded-xl text-base font-semibold text-white bg-transparent hover:bg-white/20 hover:border-white/30 border-2 border-transparent transition-all duration-300 ease-out hover:transform focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
