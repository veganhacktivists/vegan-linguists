@props(['source', 'translationRequest'])

<li class="relative">
    <a class="block hover:bg-brand-clay-50 hover:bg-opacity-50 focus:bg-brand-clay-50 focus:outline-none"
       {{ $attributes->only('href') }}>
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-brand-clay-600 pr-12 [word-break:break-word]">
                    {{ $source->title }}
                </p>
                <div class="absolute top-1/2 right-4 transform -translate-y-1/2">
                    @if ($numCompleteTranslationRequests < $totalTranslationRequests)
                        <x-heroicon-o-clock class="w-10 h-10 text-brand-clay-400" />
                    @else
                        <x-heroicon-s-badge-check class="w-10 h-10 text-brand-green-400" />
                    @endif
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    <p class="flex items-center text-brand-brown-600">
                        <x-heroicon-o-translate class="flex-shrink-0 mr-1.5 h-5 w-5 text-brand-brown-500" />
                        {{ trans_choice('{1} :count target language|[*] :count target languages', $totalTranslationRequests) }}
                    </p>
                    @if ($numCompleteTranslationRequests < $totalTranslationRequests)
                        <p class="mt-2 flex items-center text-brand-brown-600 sm:mt-0 sm:ml-6">
                            <x-heroicon-o-document-text class="flex-shrink-0 mr-1.5 h-5 w-5 text-brand-brown-500" />
                            {{ trans_choice('{1} :count translation remaining|[*] :count translations remaining', $totalTranslationRequests - $numCompleteTranslationRequests) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </a>
</li>
