@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block rounded-md py-2 px-3 text-base font-medium text-gray-900 bg-indigo-50'
            : 'block rounded-md py-2 px-3 text-base font-medium text-gray-900 hover:bg-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
