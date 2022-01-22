@props(['active'])

@php
$classes = $active ?? false ? 'bg-brand-beige-200' : 'hover:bg-brand-beige-100';
@endphp

<a
   {{ $attributes->merge([
       'class' => 'block rounded-md py-2 px-3 text-base text-brand-brown-900 ' . $classes,
   ]) }}>
    {{ $slot }}
</a>
