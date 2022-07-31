@props(['icon', 'title', 'action'])

<div {{ $attributes->merge([
    'class' => 'text-center',
]) }}>
  @if (isset($icon))
    <x-icon name="heroicon-{{ $icon }}" class="mx-auto h-12 w-12 text-brand-brown-700" />
  @endif

  <h3 class="mt-2 text-brand-brown-900">
    {{ $title }}
  </h3>

  <p class="mt-1 text-sm text-brand-brown-600">
    {{ $slot }}
  </p>

  @if (isset($action))
    <div class="mt-6">
      {{ $action }}
    </div>
  @endif
</div>
