<div class="relative z-20 bg-brand-beige-50 shadow">
  <div {{ $attributes->merge([
      'class' => 'max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 w-full',
  ]) }}>
    {{ $slot }}
  </div>
</div>
