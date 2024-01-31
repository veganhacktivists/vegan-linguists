@props(['active' => false])

@php
$classes = $active ? 'border-b border-brand-brown-900 text-brand-brown-900' : 'text-brand-brown-700 hover:text-brand-brown-900';
@endphp

<a {{ $attributes->merge([
    'class' => 'text-sm ' . $classes,
]) }}>
  {{ $slot }}
</a>
