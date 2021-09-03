@props(['icon', 'active' => false])

@php
    $class = $active
    ? 'sidebar-link active'
    : 'sidebar-link';
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    <span class="{{ isset($icon) ? 'sr-only' : '' }} ">
        {{ $slot }}
    </span>

    @if (isset($icon))
        <x-icon name="heroicon-{{ $icon }}" class="h-6 w-6" />
    @endif
</a>
