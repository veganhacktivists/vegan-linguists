@props(['source', 'translationRequest'])

<li class="relative">
    <a class="block hover:bg-brandClay-50 hover:bg-opacity-50 focus:bg-brandClay-50 focus:outline-none"
       {{ $attributes->only('href') }}>
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-brandClay-600 truncate">
                    {{ $source->title }}
                </p>
                <div class="absolute top-1/2 right-4 transform -translate-y-1/2">
                    @if ($numCompleteTranslationRequests < $totalTranslationRequests)
                        <x-heroicon-o-clock class="w-10 h-10 text-brandClay-400" />
                    @else
                        <x-heroicon-s-badge-check class="w-10 h-10 text-brandGreen-400" />
                    @endif
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    <p class="flex items-center text-brandBrown-600">
                        <x-heroicon-o-translate class="flex-shrink-0 mr-1.5 h-5 w-5 text-brandBrown-500" />
                        {{ trans_choice('{1} :count target language|[*] :count target languages', $totalTranslationRequests) }}
                    </p>
                    @if ($numCompleteTranslationRequests < $totalTranslationRequests)
                        <p class="mt-2 flex items-center text-brandBrown-600 sm:mt-0 sm:ml-6">
                            <x-heroicon-o-user-circle class="flex-shrink-0 mr-1.5 h-5 w-5 text-brandBrown-500" />
                            {{ trans_choice('{1} :count translation remaining|[*] :count translations remaining', $totalTranslationRequests - $numCompleteTranslationRequests) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </a>
</li>
