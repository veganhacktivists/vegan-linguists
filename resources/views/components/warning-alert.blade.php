@props(['title'])

<div class="rounded-md bg-yellow-50 p-4">
  <div class="flex">
    <div class="flex-shrink-0">
      <x-heroicon-o-exclamation class="w-5 h-5 text-yellow-400" />
    </div>
    <div class="ml-3">
      <h3 class="text-sm font-medium text-yellow-800">
          {{ $title }}
      </h3>
      <div class="mt-2 text-sm text-yellow-700">
        <p>
            {{ $slot }}
        </p>
      </div>
    </div>
  </div>
</div>
