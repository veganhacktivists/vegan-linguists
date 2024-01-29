<x-app-layout>
  <x-slot name="pageTitle">{{ __('Dashboard') }}</x-slot>

  <x-page-container class="mt-4">

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
      <div class="flex h-full flex-col">
        <h2 class="mb-2 text-2xl font-bold">
          {{ __('Available Translation Requests') }}
        </h2>
        <p class="mb-2 text-brand-brown-800">
          {{ __('Requests for translations in the languages that you speak') }}
        </p>
        <x-panel class="{{ $unclaimedTranslationRequests->isEmpty() ? 'items-center' : '' }} flex w-full flex-1">
          @if ($unclaimedTranslationRequests->isEmpty())
            <x-empty-state class="mx-auto p-4" icon="o-language" :title="__('No translation requests found')">
              {{ __('Try coming back another time!') }}
            </x-empty-state>
          @else
            <x-dashboard.translation-request-list :translationRequests="$unclaimedTranslationRequests" />
            <x-slot name="footer">
              <div class="text-sm">
                <a href="{{ unclaimedTranslationRequestsRoute() }}"
                  class="font-medium text-brand-clay-600 hover:text-brand-clay-800">
                  {{ __('View All') }}
                </a>
              </div>
            </x-slot>
          @endif
        </x-panel>
      </div>

      <div class="flex h-full flex-col">
        <h2 class="mb-2 text-2xl font-bold">
          {{ __('My Translations') }}
        </h2>
        <p class="mb-2 text-brand-brown-800">
          {{ __('In-progress translations, including those being reviewed by others') }}
        </p>
        <x-panel class="{{ $inProgressTranslations->isEmpty() ? 'items-center' : '' }} flex w-full flex-1">
          @if ($inProgressTranslations->isEmpty())
            <x-empty-state class="mx-auto p-4" icon="o-language" :title="__('No translations found')">
              {{ __('Want to see something here?') }}

              <x-slot name="action">
                <x-jet-button element="a" href="{{ unclaimedTranslationRequestsRoute() }}">
                  {{ __('Find content to translate') }}
                </x-jet-button>
              </x-slot>
            </x-empty-state>
          @else
            <x-dashboard.translation-request-list :translationRequests="$inProgressTranslations" displayStatus />
            <x-slot name="footer">
              <div class="text-sm">
                <a href="{{ claimedTranslationRequestsRoute() }}"
                  class="font-medium text-brand-clay-600 hover:text-brand-clay-800">
                  {{ __('View All') }}
                </a>
              </div>
            </x-slot>
          @endif
        </x-panel>
      </div>

      <div class="flex h-full flex-col">
        <h2 class="mb-2 text-2xl font-bold">
          {{ __('Reviewable Translations') }}
        </h2>
        <p class="mb-2 text-brand-brown-800">
          {{ __('Translations submitted by others that you are eligible to review') }}
        </p>
        <x-panel class="{{ $reviewableTranslationRequests->isEmpty() ? 'items-center' : '' }} flex w-full flex-1">
          @if ($reviewableTranslationRequests->isEmpty())
            <x-empty-state class="mx-auto p-4" icon="o-language" :title="__('No translations found')">
              {{ __('Try coming back another time!') }}
            </x-empty-state>
          @else
            <x-dashboard.translation-request-list :translationRequests="$reviewableTranslationRequests" />
            <x-slot name="footer">
              <div class="text-sm">
                <a href="{{ reviewableTranslationRequestsRoute() }}"
                  class="font-medium text-brand-clay-600 hover:text-brand-clay-800">
                  {{ __('View All') }}
                </a>
              </div>
            </x-slot>
          @endif
        </x-panel>
      </div>

      <div class="flex h-full flex-col">
        <h2 class="mb-2 text-2xl font-bold">
          {{ __("Translations I'm Reviewing") }}
        </h2>
        <p class="mb-2 text-brand-brown-800">
          {{ __("Translations you've chosen to review that don't yet have enough approvals") }}
        </p>
        <x-panel
          class="{{ $translationRequestsClaimedForReview->isEmpty() ? 'items-center' : '' }} flex w-full flex-1">
          @if ($translationRequestsClaimedForReview->isEmpty())
            <x-empty-state class="mx-auto p-4" icon="o-language" :title="__('No translations found')">
              {{ __('Want to see something here?') }}

              <x-slot name="action">
                <x-jet-button element="a" href="{{ reviewableTranslationRequestsRoute() }}">
                  {{ __('Find translations to review') }}
                </x-jet-button>
              </x-slot>
            </x-empty-state>
          @else
            <x-dashboard.translation-request-list :translationRequests="$translationRequestsClaimedForReview" displayStatus />
            <x-slot name="footer">
              <div class="text-sm">
                <a href="{{ underReviewTranslationRequestsRoute() }}"
                  class="font-medium text-brand-clay-600 hover:text-brand-clay-800">
                  {{ __('View All') }}
                </a>
              </div>
            </x-slot>
          @endif
        </x-panel>
      </div>
    </div>
  </x-page-container>

</x-app-layout>
