@props(['title'])

<div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
  <h3 class="text-lg leading-6 font-medium text-gray-900">
      {{ $title }}
  </h3>
  <div class="mt-3 sm:mt-0 sm:ml-4 flex-1">
      {{ $slot }}
  </div>
</div>
