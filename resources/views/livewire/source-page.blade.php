<div class="bg-white h-full flex flex-col">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $source->title }}

                @if ($isViewingTranslation)
                    ({{ $currentTranslationRequest->language->name }})
                @endif
            </h2>
        </div>
    </x-slot>
    @if ($isViewingTranslation && $currentTranslationRequest->isClaimed())
        <x-header-action-bar>
            <div class="flex justify-between items-center">
                <div class="flex gap-2 items-center flex-wrap">
                    @if ($currentTranslationRequest->isComplete() || $currentTranslationRequest->isClaimed())

                        <x-user-photo
                            :user="$currentTranslationRequest->translator"
                            class="h-10 w-10" />
                        {{ $currentTranslationRequest->translator->name }}
                    @endif
                </div>

                <div class="flex gap-2 flex-wrap">
                    <x-jet-secondary-button element="a" href="{{ route('source', [$source->id, $source->slug]) }}">
                        {{ __('View original') }}
                    </x-jet-secondary-button>
                    @if ($currentTranslationRequest->isClaimed())
                        <x-jet-danger-button type="button" wire:click="$toggle('isConfirmingClaimRevocation')">
                            {{ __('Revoke claim') }}
                        </x-jet-danger-button>
                    @endif
                </div>
            </div>
        </x-header-action-bar>
    @endif

    <div class="bg-white">
        <div class="flex flex-col lg:flex-row max-w-7xl mx-auto">
            <div class="pl-6 pr-6 lg:pr-0 pt-6 flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                    @foreach ($source->translationRequests as $translationRequest)
                        <x-dashboard.translation-request-row
                            class=""
                            :translationRequest="$translationRequest"
                            :source="$source" />
                    @endforeach
                </div>
            </div>
            <div class="prose prose-lg prose-indigo p-6 w-full" wire:ignore>
                <x-rich-text-editor
                    :content="$isViewingTranslation ? $currentTranslationRequest->content : $source->content"
                    :isReadOnly="true" />
            </div>
        </div>
    </div>

    @if ($isViewingTranslation && $currentTranslationRequest->isClaimed())
        <x-jet-confirmation-modal wire:model="isConfirmingClaimRevocation">
            <x-slot name="title">
                {{ __('Revoke claim') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to revoke :translatorName\'s claim on this translation request?', [
                    'translatorName' => $currentTranslationRequest->translator->name,
                ]) }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('isConfirmingClaimRevocation')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="revokeClaim" wire:loading.attr="disabled">
                    {{ __('Yes') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
