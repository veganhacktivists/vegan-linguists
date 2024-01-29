@props(['source', 'translationRequest'])

<li class="relative">
  <a class="block hover:bg-brand-clay-50 hover:bg-opacity-50 focus:bg-brand-clay-50 focus:outline-none"
    {{ $attributes->only('href') }}>
    <div class="px-4 py-4 sm:px-6">
      <div class="flex items-center justify-between">
        <p class="pr-12 text-brand-clay-600 [word-break:break-word]">
          {{ $source->title }}
        </p>
        <div class="absolute top-1/2 right-4 -translate-y-1/2 transform">
          @if ($numCompleteTranslationRequests < $totalTranslationRequests)
            <x-heroicon-o-clock class="h-10 w-10 text-brand-clay-400" />
          @else
            <x-heroicon-s-check-badge class="h-10 w-10 text-brand-green-400" />
          @endif
        </div>
      </div>
      <div class="mt-2 sm:flex sm:justify-between">
        <div class="sm:flex">
          <p class="flex items-center text-brand-brown-600">
            <x-heroicon-o-language class="mr-1.5 h-5 w-5 flex-shrink-0 text-brand-brown-500" />
            {{ trans_choice('{1} :count target language|[*] :count target languages', $totalTranslationRequests) }}
          </p>
          @if ($numCompleteTranslationRequests < $totalTranslationRequests)
            <p class="mt-2 flex items-center text-brand-brown-600 sm:mt-0 sm:ml-6">
              <x-heroicon-o-document-text class="mr-1.5 h-5 w-5 flex-shrink-0 text-brand-brown-500" />
              {{ trans_choice('{1} :count translation remaining|[*] :count translations remaining', $totalTranslationRequests - $numCompleteTranslationRequests) }}
            </p>
          @endif
        </div>
      </div>
    </div>
  </a>
</li>
