<div {{ $attributes->merge([
    'class' => 'px-8 pb-8',
]) }}>
  <div class="mx-auto max-w-7xl">
    {{ $slot }}
  </div>
</div>
