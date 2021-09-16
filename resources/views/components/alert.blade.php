@props(['title' => null, 'type', 'icon'])
@php
// This is silly, but it's to satisfy PostCSS purging
if ($type === 'warning') {
    $classes = [
        'container' => 'bg-yellow-50',
        'icon' => 'text-yellow-400',
        'title' => 'text-yellow-800',
        'message' => 'text-yellow-700',
    ];
} elseif ($type === 'success') {
    $classes = [
        'container' => 'bg-green-50',
        'icon' => 'text-green-400',
        'title' => 'text-green-800',
        'message' => 'text-green-700',
    ];
}
@endphp

<div class="rounded-md p-4 {{ $classes['container'] }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-icon name="heroicon-{{ $icon }}"
                    class="w-5 h-5 {{ $classes['icon'] }}" />
        </div>
        <div class="ml-3">
            @if (!empty($title))
                <h3 class="text-sm font-medium mb-2 {{ $classes['title'] }}">
                    {{ $title }}
                </h3>
            @endif
            <div class="text-sm {{ $classes['message'] }}">
                <p>
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</div>
