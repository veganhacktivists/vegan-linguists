@props(['source', 'translationRequest'])

<li {{ $attributes->except('href') }}>
  <a class="block hover:bg-brand-clay-50 hover:bg-opacity-50 focus:bg-brand-clay-50 focus:outline-none"
    {{ $attributes->only('href') }}>
    <div class="px-4 py-4 sm:px-6">
      <div class="flex items-center justify-between">
        <p class="truncate text-brand-clay-600">
          {{ $translationRequest->source->title }}
        </p>
        <div class="ml-2 flex flex-shrink-0">
          <p class="inline-flex text-lg font-semibold leading-5 text-brand-clay-700">
            {{ $translationRequest->language->native_name }}
          </p>
        </div>
      </div>
      <div class="mt-2 sm:flex sm:justify-between">
        <div class="sm:flex">
          <p class="flex items-center text-brand-brown-600">
            <x-heroicon-o-language class="mr-1.5 h-5 w-5 flex-shrink-0 text-brand-brown-500" />
            {{ $translationRequest->source->language->native_name }}
          </p>
          <p class="mt-2 flex items-center text-brand-brown-600 sm:mt-0 sm:ml-6">
            <x-heroicon-o-user-circle class="mr-1.5 h-5 w-5 flex-shrink-0 text-brand-brown-500" />
            {{ $translationRequest->source->author->name }}
          </p>
        </div>
      </div>
    </div>
  </a>
</li>
