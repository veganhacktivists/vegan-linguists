@php
// $claimedRoute = route('home', \Request::except('filter'));
// $unclaimedRoute = route('home', ['filter' => 'unclaimed'] + \Request::all());
// $completedRoute = route('home', ['filter' => 'complete'] + \Request::all());
@endphp

<div class="max-w-7xl mx-auto">
    <x-slot name="pageTitle">{{ __('Translation Review') }}</x-slot>
    {{-- <div x-data="{ source: '{{ $sourceLanguageCode }}', target: '{{ $targetLanguageCode }}', url: new URL(window.location) }"
             class="flex w-full max-w-2xl p-4 items-center gap-4">
            <div class="w-full">
                <x-jet-label class="mb-1"
                             for="source-language">{{ __('Original Language') }}</x-jet-label>
                <x-jet-select x-model="source"
                              id="source-language"
                              class="w-full"
                              @change="url.searchParams.set('source', source); window.Turbolinks.visit(url)">
                    <x-jet-option value="">
                        {{ __('All') }}
                    </x-jet-option>
                    @foreach ($languages as $language)
                        <x-jet-option :value="$language->code"
                                      :selected="$language->code === $sourceLanguageCode">
                            {{ $language->native_name }}
                        </x-jet-option>
                    @endforeach
                </x-jet-select>
            </div>

            <div class="mt-6">
                <x-heroicon-o-arrow-circle-right class="h-6 w-6" />
            </div>

            <div class="w-full">
                <x-jet-label class="mb-1"
                             for="source-language">{{ __('Target Language') }}</x-jet-label>
                <x-jet-select x-model="target"
                              class="w-full"
                              @change="url.searchParams.set('target', target); window.Turbolinks.visit(url)">
                    <x-jet-option value="">
                        {{ __('All') }}
                    </x-jet-option>
                    @foreach ($languages as $language)
                        <x-jet-option :value="$language->code"
                                      :selected="$language->code === $targetLanguageCode">
                            {{ $language->native_name }}
                        </x-jet-option>
                    @endforeach
                </x-jet-select>
            </div>
        </div> --}}

    <div class="sm:mx-4">

        <h2 class="text-2xl font-bold mb-4 text-center px-4 sm:px-0 sm:text-left">
            {{ __('Translation Review') }}
        </h2>

        <h2 class="text-xl font-bold mb-4 text-center px-4 sm:px-0 sm:text-left">
            {{ __('Needs reviewers') }}
        </h2>

        <x-stacked-list class="sm:rounded-md">
            @foreach ($translationsInNeedOfReview as $translationRequest)
                <x-dashboard.translation-request-row :translationRequest="$translationRequest"
                                                     :href="route('translate', [$translationRequest->id, $translationRequest->source->slug])" />
            @endforeach
        </x-stacked-list>

        <h2 class="text-xl font-bold mb-4 text-center px-4 sm:px-0 sm:text-left">
            {{ __('Things I\'ve Claimed For Review') }}
        </h2>

        <h2 class="text-xl font-bold mb-4 text-center px-4 sm:px-0 sm:text-left">
            {{ __('Reviewed by you') }}
        </h2>


    </div>
</div>
