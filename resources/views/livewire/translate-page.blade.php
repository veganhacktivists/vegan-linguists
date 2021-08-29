@php($isMine = $translationRequest->isClaimedBy(Auth::user()))

<div class="bg-white h-full flex flex-col">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $translationRequest->source->title }}
            </h2>
        </div>
    </x-slot>

    <x-header-action-bar>
        @can('claim', $translationRequest)
            <div class="flex items-center justify-between">
                <div class="text-xl font-bold">
                    {{ $translationRequest->language->native_name }}
                </div>
                <div class="text-right">
                    <x-jet-button type="button" wire:click="claimTranslationRequest">
                        {{ __('Claim') }}
                    </x-jet-button>
                </div>
            </div>
        @elseif ($isMine)
            <div class="flex items-center justify-between gap-2">
                <div class="text-xl font-bold">
                    {{ $translationRequest->language->native_name }}
                </div>
                <div class="flex flex-wrap justify-end gap-2">
                    <x-success-toast
                        class="fixed right-4 bottom-4 flex items-center gap-2 opacity-0 transition-opacity duration-500"
                        x-data="{ saved: false, timeout: null}"
                        x-bind:class="{ 'opacity-0': !saved }"
                        @toast-translation-request-saved.window.debounce.3000ms="saved = true; clearTimeout(timeout); timeout = setTimeout(() => saved = false, 1500)"
                    >
                        <x-heroicon-s-cloud-upload class="w-6 h-6" />
                        {{ __('Saved') }}
                    </x-success-toast>
                    <x-jet-danger-button type="button" wire:click="$toggle('isConfirmingUnclaim')">
                        {{ __('Unclaim') }}
                    </x-jet-danger-button>

                    <x-jet-button
                        type="button"
                        :disabled="strlen(trim($translationPlainText)) === 0"
                        wire:click="$toggle('isConfirmingSubmission')"
                    >
                        {{ __('Submit Translation') }}
                    </x-jet-button>
                </div>
            </div>
        @else
            <p class="text-center">
                {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
            </p>
        @endcan
    </x-header-action-bar>

    <div class="bg-white flex h-full">
        <div class="flex flex-col lg:flex-row max-w-7xl mx-auto divide-y lg:divide-x lg:divide-y-0 divide-gray-200">
            <div class="prose prose-lg prose-indigo lg:px-6 py-8 mx-6 lg:mx-auto {{ $isMine ? 'lg:w-1/2 lg:pt-40 transform lg:-translate-y-2' : '' }}">
                <x-rich-text-editor
                    wire:ignore
                    :content="$translationRequest->source->content"
                    :isReadOnly="true" />
            </div>
            @if ($isMine)
                <div class="prose prose-lg prose-indigo p-6 mx-auto flex-1 lg:w-1/2">
                    <x-rich-text-editor
                        wire:ignore
                        :content="$translationRequest->content"
                        x-on:change="e => { $wire.saveTranslation(e.detail.content, e.detail.plainText) }" />
                </div>

                <x-jet-confirmation-modal wire:model="isConfirmingUnclaim">
                    <x-slot name="title">
                        {{ __('Unclaim Translation Request') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Are you sure you would like to unclaim this translation request?') }}
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('isConfirmingUnclaim')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        <x-jet-danger-button class="ml-2" wire:click="unclaimTranslationRequest" wire:loading.attr="disabled">
                            {{ __('Unclaim') }}
                        </x-jet-danger-button>
                    </x-slot>
                </x-jet-confirmation-modal>

                <x-jet-confirmation-modal wire:model="isConfirmingSubmission">
                    <x-slot name="title">
                        {{ __('Submit Translation Request') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Are you sure you would like to submit this translation?') }}
                        <strong class="block mt-3">
                            {{ __(' Make sure you are finished, because this cannot be undone.') }}
                        </strong>
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('isConfirmingSubmission')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        <x-jet-danger-button class="ml-2" wire:click="submitTranslation" wire:loading.attr="disabled">
                            {{ __('Submit') }}
                        </x-jet-danger-button>
                    </x-slot>
                </x-jet-confirmation-modal>
            @endif
        </div>
    </div>
</div>
