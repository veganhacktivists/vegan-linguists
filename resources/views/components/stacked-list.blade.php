<div {{ $attributes->merge([
    'class' => 'bg-white shadow overflow-hidden',
]) }}>
  <ul role="list" class="divide-y divide-gray-200">
    {{ $slot }}
  </ul>
</div>
