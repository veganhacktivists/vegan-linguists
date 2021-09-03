@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-sm font-medium text-gray-900'
            : 'text-sm font-medium text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
