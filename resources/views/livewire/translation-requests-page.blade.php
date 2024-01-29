@php
$unclaimedRoute = unclaimedTranslationRequestsRoute();
$claimedRoute = claimedTranslationRequestsRoute();
$completedRoute = completedTranslationRequestsRoute();
@endphp

<x-slot name="pageTitle">
  {{ __('Translation Requests') }}
</x-slot>

<x-page-container>
  <div x-data="{ source: '{{ $sourceLanguageCode }}', target: '{{ $targetLanguageCode }}', url: new URL(window.location) }" class="flex w-full max-w-2xl items-center gap-4 p-4">
    <div class="w-full">
      <x-jet-label class="mb-1" for="source-language">{{ __('Original Language') }}</x-jet-label>
      <x-jet-select x-model="source" id="source-language" class="w-full"
        @change="url.searchParams.set('source', source); window.location.href = url">
        <x-jet-option value="">
          {{ __('All') }}
        </x-jet-option>
        @foreach ($languages as $language)
          <x-jet-option :value="$language->code" :selected="$language->code === $sourceLanguageCode">
            {{ $language->native_name }}
          </x-jet-option>
        @endforeach
      </x-jet-select>
    </div>

    <div class="mt-6">
      <x-heroicon-o-arrow-right-circle class="h-6 w-6" />
    </div>

    <div class="w-full">
      <x-jet-label class="mb-1" for="source-language">{{ __('Target Language') }}</x-jet-label>
      <x-jet-select x-model="target" class="w-full"
        @change="url.searchParams.set('target', target); window.location.href = url">
        <x-jet-option value="">
          {{ __('All') }}
        </x-jet-option>
        @foreach ($languages as $language)
          <x-jet-option :value="$language->code" :selected="$language->code === $targetLanguageCode">
            {{ $language->native_name }}
          </x-jet-option>
        @endforeach
      </x-jet-select>
    </div>
  </div>

  <div class="sm:mx-4">
    <h2 class="mb-4 px-4 text-center text-2xl font-bold sm:px-0 sm:text-left">
      @if ($this->isMinePage())
        {{ __('My Translations') }}
      @elseif ($this->isReviewablePage())
        {{ __('Reviewable Translations') }}
      @elseif ($this->isUnderReviewPage())
        {{ __("Translations I'm Reviewing") }}
      @elseif ($this->isCompletedPage())
        {{ __('My Completed Translations') }}
      @else
        {{ __('Available Translation Requests') }}
      @endif
    </h2>

    @if ($translationRequests->count() > 0)
      <x-panel>
        <x-dashboard.translation-request-list :translationRequests="$translationRequests" :displayStatus="$this->isMinePage() || $this->isCompletedPage()" :displayPriority="$this->isAvailablePage()">
        </x-dashboard.translation-request-list>
      </x-panel>
    @elseif ($this->isMinePage())
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('No claimed translation requests')">

        @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
          {{ __('Try selecting different languages to broaden your search.') }}
        @else
          {{ __('Want to see something here?') }}
        @endif

        <x-slot name="action">
          <x-jet-button element="a" href="{{ $unclaimedRoute }}">
            {{ __('Find content to translate') }}
          </x-jet-button>
        </x-slot>
      </x-empty-state>
    @elseif ($this->isReviewablePage())
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('No translations found')">

        @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
          {{ __('Try selecting different languages to broaden your search.') }}
        @else
          {{ __('Try coming back another time!') }}
        @endif
      </x-empty-state>
    @elseif ($this->isUnderReviewPage())
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('No translations found')">

        @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
          {{ __('Try selecting different languages to broaden your search.') }}
        @else
          {{ __('Want to see something here?') }}
        @endif

        <x-slot name="action">
          <x-jet-button element="a" href="{{ reviewableTranslationRequestsRoute() }}">
            {{ __('Find translations to review') }}
          </x-jet-button>
        </x-slot>
      </x-empty-state>
    @elseif ($this->isCompletedPage())
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('No translations found')">
        @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
          {{ __('Try selecting different languages to broaden your search.') }}
        @else
          {{ __('Want to see something here?') }}
        @endif

        <x-slot name="action">
          <x-jet-button element="a" href="{{ $unclaimedRoute }}">
            {{ __('Find content to translate') }}
          </x-jet-button>
        </x-slot>
      </x-empty-state>
    @else
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('No translation requests found')">
        @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
          {{ __('Try selecting different languages to broaden your search.') }}
        @else
          {{ __('Try coming back another time!') }}
        @endif
      </x-empty-state>
    @endif
  </div>
</x-page-container>
