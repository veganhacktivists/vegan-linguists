@props(['title' => null, 'type', 'icon'])
@php
// This is silly, but it's to satisfy PostCSS purging
if ($type === 'warning') {
    $classes = [
        'container' => 'bg-yellow-50 border border-yellow-400',
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

<div class="{{ $classes['container'] }} rounded-md p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <x-icon name="heroicon-{{ $icon }}" class="{{ $classes['icon'] }} h-5 w-5" />
    </div>
    <div class="ml-3">
      @if (!empty($title))
        <h3 class="{{ $classes['title'] }} mb-2 text-sm">
          {{ $title }}
        </h3>
      @endif
      <div class="{{ $classes['message'] }} text-sm">
        <p>
          {{ $slot }}
        </p>
      </div>
    </div>
  </div>
</div>
