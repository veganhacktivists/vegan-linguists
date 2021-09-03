<div class="flex flex-col h-full">
    <x-slot name="sidebar">
    </x-slot>

    <x-slot name="aside">
        <x-slot name="asideTitle">
            {{ __('Change Language') }}
        </x-slot>

        <x-stacked-list class="sticky top-0">
            <li class="{{ $isViewingTranslation ? 'bg-white' : 'bg-gray-50' }}">
                <a href="{{ route('source', [$source->id, $source->slug]) }}" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6 font-medium text-indigo-600 truncate">
                        {{ __(':languageName (Original)', ['languageName' => $source->language->native_name]) }}
                    </div>
                </a>
            </li>

            @foreach ($source->translationRequests as $translationRequest)
                <li class="{{ $translationRequest->is($currentTranslationRequest) ? 'bg-gray-50' : '' }}">
                    <a href="{{ route('translation', [$source->id, $translationRequest->language->id]) }}"
                       class="px-4 py-4 sm:px-6 flex justify-between items-center hover:bg-gray-50">
                        <div class="font-medium text-indigo-600 truncate">
                            {{ $translationRequest->language->name }}
                            ({{ $translationRequest->language->native_name }})
                        </div>
                        <div>
                            @if ($translationRequest->isComplete())
                                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
                            @elseif ($translationRequest->isClaimed())
                                <x-heroicon-o-pencil class="w-6 h-6 text-indigo-600" />
                            @else
                                <x-heroicon-o-clock class="w-6 h-6 text-yellow-400" />
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </x-stacked-list>
    </x-slot>

    @if ($isViewingTranslation && $currentTranslationRequest->isClaimed())
        <x-header-action-bar class="bg-indigo-50">
            <div class="flex gap-2 justify-between items-center">
                @if ($currentTranslationRequest->isComplete() || $currentTranslationRequest->isClaimed())
                    <div class="truncate">
                        <x-user-photo
                            :user="$currentTranslationRequest->translator"
                            class="h-10 w-10 inline-block" />

                        <span class="align-middle">
                            {{ __(':translatorName has claimed this translation request', [
                                'translatorName' => $currentTranslationRequest->translator->name,
                            ]) }}
                        </span>
                    </div>
                @endif

                <div>
                    @if ($currentTranslationRequest->isClaimed())
                        <x-jet-danger-button class="whitespace-nowrap" type="button" wire:click="$toggle('isConfirmingClaimRevocation')">
                            {{ __('Revoke claim') }}
                        </x-jet-danger-button>
                    @endif
                </div>
            </div>
        </x-header-action-bar>
    @endif

    <div class="bg-white p-6 w-full overflow-auto flex-1" wire:key="rich-text-editor" wire:ignore>
        <x-rich-text-editor
            :content="$isViewingTranslation ? $currentTranslationRequest->content : $source->content"
            :isReadOnly="true" />
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
