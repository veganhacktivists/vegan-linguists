@props(['active' => false])

@php
$classes = $active ? 'border-b border-brandBrown-900 text-brandBrown-900' : 'text-brandBrown-700 hover:text-brandBrown-900';
@endphp

<a {{ $attributes->merge([
    'class' => 'text-sm ' . $classes,
]) }}>
    {{ $slot }}
</a>
