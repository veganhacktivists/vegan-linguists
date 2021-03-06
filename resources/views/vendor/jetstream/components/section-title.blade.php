<div class="flex justify-between md:col-span-1">
  <div class="px-4 sm:px-0">
    <h3 class="text-lg text-brand-brown-900">{{ $title }}</h3>

    <p class="mt-1 text-sm text-brand-brown-600">
      {{ $description }}
    </p>
  </div>

  <div class="px-4 sm:px-0">
    {{ $aside ?? '' }}
  </div>
</div>
