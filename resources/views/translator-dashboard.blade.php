<x-app-layout>
    <x-slot name="pageTitle">{{ __('Dashboard') }}</x-slot>

    <x-page-container class="mt-4">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="flex h-full flex-col">
                <h2 class="text-2xl font-bold mb-2">
                    {{ __('Available Translation Requests') }}
                </h2>
                <p class="mb-2 text-brand-brown-800">
                    {{ __('Requests for translations in the languages that you speak') }}
                </p>
                <x-panel
                         class="w-full flex flex-1 {{ $unclaimedTranslationRequests->isEmpty() ? 'items-center' : '' }}">
                    @if ($unclaimedTranslationRequests->isEmpty())
                        <x-empty-state class="mx-auto p-4"
                                       icon="o-translate"
                                       :title="__('No translation requests found')">
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
                <h2 class="text-2xl font-bold mb-2">
                    {{ __('My Translations') }}
                </h2>
                <p class="mb-2 text-brand-brown-800">
                    {{ __('In-progress translations, including those being reviewed by others') }}
                </p>
                <x-panel class="w-full flex flex-1 {{ $inProgressTranslations->isEmpty() ? 'items-center' : '' }}">
                    @if ($inProgressTranslations->isEmpty())
                        <x-empty-state class="mx-auto p-4"
                                       icon="o-translate"
                                       :title="__('No translations found')">
                            {{ __('Want to see something here?') }}

                            <x-slot name="action">
                                <x-jet-button element="a"
                                              href="{{ unclaimedTranslationRequestsRoute() }}">
                                    {{ __('Find content to translate') }}
                                </x-jet-button>
                            </x-slot>
                        </x-empty-state>
                    @else
                        <x-dashboard.translation-request-list :translationRequests="$inProgressTranslations"
                                                              displayStatus />
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
                <h2 class="text-2xl font-bold mb-2">
                    {{ __('Reviewable Translations') }}
                </h2>
                <p class="mb-2 text-brand-brown-800">
                    {{ __('Translations submitted by others that you are eligible to review') }}
                </p>
                <x-panel
                         class="w-full flex flex-1 {{ $reviewableTranslationRequests->isEmpty() ? 'items-center' : '' }}">
                    @if ($reviewableTranslationRequests->isEmpty())
                        <x-empty-state class="mx-auto p-4"
                                       icon="o-translate"
                                       :title="__('No translations found')">
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
                <h2 class="text-2xl font-bold mb-2">
                    {{ __("Translations I'm Reviewing") }}
                </h2>
                <p class="mb-2 text-brand-brown-800">
                    {{ __("Translations you've chosen to review that don't yet have enough approvals") }}
                </p>
                <x-panel
                         class="w-full flex flex-1 {{ $translationRequestsClaimedForReview->isEmpty() ? 'items-center' : '' }}">
                    @if ($translationRequestsClaimedForReview->isEmpty())
                        <x-empty-state class="mx-auto p-4"
                                       icon="o-translate"
                                       :title="__('No translations found')">
                            {{ __('Want to see something here?') }}

                            <x-slot name="action">
                                <x-jet-button element="a"
                                              href="{{ reviewableTranslationRequestsRoute() }}">
                                    {{ __('Find translations to review') }}
                                </x-jet-button>
                            </x-slot>
                        </x-empty-state>
                    @else
                        <x-dashboard.translation-request-list :translationRequests="$translationRequestsClaimedForReview"
                                                              displayStatus />
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
