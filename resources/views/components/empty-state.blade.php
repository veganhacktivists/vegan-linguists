@props(['icon', 'title', 'action'])

<div {{ $attributes->merge([
    'class' => 'text-center',
]) }}>
    @if (isset($icon))
        <x-icon name="heroicon-{{ $icon }}" class="mx-auto h-12 w-12 text-gray-400" />
    @endif

  <h3 class="mt-2 font-medium text-gray-900">
      {{ $title }}
  </h3>

  <p class="mt-1 text-sm text-gray-500">
      {{ $slot }}
  </p>

  @if (isset($action))
      <div class="mt-6">
          {{ $action }}
      </div>
  @endif
</div>

