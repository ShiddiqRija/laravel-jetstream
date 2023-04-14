@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block border-l-4 border-indigo-400 block py-2 px-4 bg-white text-gray-900 font-semibold hover:bg-gray-300 transition duration-150 ease-in-out'
            : 'block py-2 px-4 bg-white text-gray-900 font-semibold hover:bg-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
