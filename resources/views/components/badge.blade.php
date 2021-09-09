@props(['color'])

<span {{ $attributes->merge([
    'class' => "inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-$color-100 text-gray-800",
]) }}>
    {{ $slot }}
</span>
