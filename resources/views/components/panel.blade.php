<div
  {{ $attributes->merge([
      'class' =>
          'relative bg-white pt-5 px-4 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden ' .
          (empty($footer) ? '' : ' pb-12'),
  ]) }}>

  <div class="flex w-full items-baseline pb-6 sm:pb-7">
    {{ $slot }}

    @if (!empty($footer))
      <div class="absolute inset-x-0 bottom-0 bg-brand-beige-50 bg-opacity-50 px-4 py-4 sm:px-6">
        {{ $footer }}
      </div>
    @endif
  </div>
</div>
