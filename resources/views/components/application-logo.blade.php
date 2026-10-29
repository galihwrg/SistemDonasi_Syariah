@props([
    'class' => 'h-12 w-auto object-contain rounded-xl shadow-sm',
    'alt'   => 'Logo Kuantum Pelopor Indonesia'
])

<img src="{{ asset('images/logo.png') }}"
     alt="{{ $alt }}"
     {{ $attributes->merge(['class' => $class]) }}>
