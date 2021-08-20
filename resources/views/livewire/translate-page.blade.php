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
            <div class="text-right">
                <x-jet-button type="button" wire:click="claimTranslationRequest">
                    {{ __('Claim') }}
                </x-jet-button>
            </div>
        @elseif ($isMine)
            <div class="text-right">
                <x-jet-button type="button" wire:click="unclaimTranslationRequest">
                    {{ __('Unclaim') }}
                </x-jet-button>
            </div>
        @else
            <p class="text-center">
                {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
            </p>
        @endcan
    </x-header-action-bar>

    <div class="bg-white">
        <div class="flex flex-col lg:flex-row max-w-7xl mx-auto">
            <div class="prose prose-lg prose-indigo p-6 mx-auto flex-1">
                <x-rich-text-editor
                    wire:ignore
                    :content="$translationRequest->source->content"
                    :isReadOnly="true" />
            </div>
            @if ($isMine)
                <div class="prose prose-lg prose-indigo p-6 mx-auto flex-1">
                    <x-rich-text-editor :content="$translationRequest->content" />
                </div>
            @endif
        </div>
    </div>
</div>
