@php
$claimedRoute = route('home', \Request::except('filter'));
$unclaimedRoute = route('home', ['filter' => 'unclaimed'] + \Request::all());
$completedRoute = route('home', ['filter' => 'complete'] + \Request::all());
@endphp

<x-app-layout>
    <x-slot name="pageTitle">{{ __('Dashboard') }}</x-slot>

    <div class="max-w-7xl mx-auto">
        <div x-data="{ source: '{{ $sourceLanguageCode }}', target: '{{ $targetLanguageCode }}', url: new URL(window.location) }"
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
        </div>

        <div class="sm:mx-4">
            <h2 class="text-2xl font-bold mb-4 text-center px-4 sm:px-0 sm:text-left">
                @if ($filter === 'complete')
                    {{ __('My Completed Translations') }}
                @elseif ($filter === 'unclaimed')
                    {{ __('Unclaimed Content – Needs Translation') }}
                @else
                    {{ __('My Claimed Translation Requests') }}
                @endif
            </h2>

            @if ($translationRequests->count() > 0)
                <x-stacked-list class="sm:rounded-md">
                    @foreach ($translationRequests as $translationRequest)
                        <x-dashboard.translation-request-row :translationRequest="$translationRequest"
                                                             :href="route('translate', [$translationRequest->id, $translationRequest->source->slug])" />
                    @endforeach
                </x-stacked-list>
            @elseif ($filter === 'unclaimed')
                <x-empty-state class="bg-white shadow rounded-md p-8"
                               icon="o-translate"
                               :title="__('No translation requests found')">
                    @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                        {{ __('Try selecting different languages to broaden your search.') }}
                    @else
                        {{ __('Try coming back another time!') }}
                    @endif
                </x-empty-state>
            @elseif ($filter === 'complete')
                <x-empty-state class="bg-white shadow rounded-md p-8"
                               icon="o-translate"
                               :title="__('No translations found')">
                    @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                        {{ __('Try selecting different languages to broaden your search.') }}
                    @else
                        {{ __('Want to see something here?') }}
                    @endif

                    <x-slot name="action">
                        <x-jet-button element="a"
                                      href="{{ $unclaimedRoute }}">
                            {{ __('Find content to translate') }}
                        </x-jet-button>
                    </x-slot>
                </x-empty-state>
            @else
                <x-empty-state class="bg-white shadow rounded-md p-8"
                               icon="o-translate"
                               :title="__('No claimed translation requests')">

                    @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                        {{ __('Try selecting different languages to broaden your search.') }}
                    @else
                        {{ __('Want to see something here?') }}
                    @endif

                    <x-slot name="action">
                        <x-jet-button element="a"
                                      href="{{ $unclaimedRoute }}">
                            {{ __('Find content to translate') }}
                        </x-jet-button>
                    </x-slot>
                </x-empty-state>
            @endif
        </div>
    </div>
</x-app-layout>
