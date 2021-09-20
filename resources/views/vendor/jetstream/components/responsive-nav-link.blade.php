@props(['active'])

@php
$classes = $active ?? false ? 'bg-brandBeige-200' : 'hover:bg-brandBeige-100';
@endphp

<a
   {{ $attributes->merge([
    'class' => 'block rounded-md py-2 px-3 text-base text-brandBrown-900 ' . $classes,
]) }}>
    {{ $slot }}
</a>
