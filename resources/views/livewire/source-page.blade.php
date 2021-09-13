@php($deletedUser = App\Models\User::deletedUser())

<div class="flex flex-col h-full">
    <x-slot name="pageTitle">{{ $source->title }}</x-slot>

    <x-slot name="aside">
        <x-slot name="asideTitle">
            {{ __('Change Language') }}
        </x-slot>

        <x-stacked-list class="sticky top-0">
            <li class="{{ $isViewingTranslation ? 'bg-white hover:bg-gray-50' : 'bg-indigo-50' }}">
                <a href="{{ route('source', [$source->id, $source->slug]) }}" class="block">
                    <div class="px-4 py-4 sm:px-6 font-medium text-indigo-600 truncate">
                        {{ __(':languageName (Original)', ['languageName' => $source->language->native_name]) }}
                    </div>
                </a>
            </li>

            @foreach ($source->translationRequests as $translationRequest)
                <li class="{{ $translationRequest->is($currentTranslationRequest) ? 'bg-indigo-50' : 'bg-white hover:bg-gray-50' }}">
                    <a href="{{ route('translation', [$source->id, $translationRequest->language->id]) }}"
                       class="px-4 py-4 sm:px-6 flex justify-between items-center">
                        <div class="font-medium text-indigo-600 truncate">
                            {{ $translationRequest->language->name }}
                            ({{ $translationRequest->language->native_name }})
                        </div>
                        <div>
                            @if ($translationRequest->isComplete())
                                <x-heroicon-o-check class="w-6 h-6 text-green-500" />
                            @elseif ($translationRequest->isClaimed())
                                <x-heroicon-o-beaker class="w-6 h-6 text-indigo-600" />
                            @else
                                <x-heroicon-o-clock class="w-6 h-6 text-yellow-400" />
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </x-stacked-list>
    </x-slot>

    <x-header-action-bar>
        <div class="flex gap-2 justify-between items-center">
            @if (!$isViewingTranslation)
                <div class="truncate">
                    {{ $source->title }}
                </div>
                <div>
                    <x-jet-danger-button class="whitespace-nowrap" type="button" wire:click="$toggle('isConfirmingSourceDeletion')">
                        {{ __('Delete Content') }}
                    </x-jet-danger-button>
                </div>
            @elseif ($currentTranslationRequest->isClaimed())
                <div class="truncate">
                    <x-user-photo
                        :user="$currentTranslationRequest->translator"
                        class="h-10 w-10 inline-block" />

                    {{ __(':translatorName has claimed this translation request', [
                        'translatorName' => $currentTranslationRequest->translator->name,
                    ]) }}
                </div>
                <div>
                    <x-jet-danger-button class="whitespace-nowrap" type="button" wire:click="$toggle('isConfirmingClaimRevocation')">
                        {{ __('Revoke Claim') }}
                    </x-jet-danger-button>
                </div>
            @elseif ($currentTranslationRequest->isComplete())
                <div class="truncate">
                    <x-user-photo
                        :user="$currentTranslationRequest->translator"
                        class="h-10 w-10 inline-block" />

                    {{ __(':translatorName translated this content', [
                        'translatorName' => ($currentTranslationRequest->translator ?? $deletedUser)->name,
                    ]) }}
                </div>
                <div>
                    <x-jet-danger-button class="whitespace-nowrap" type="button" wire:click="$toggle('isConfirmingTranslationRequestDeletion')">
                        {{ __('Delete Translation') }}
                    </x-jet-danger-button>
                </div>
            @else
                <div class="truncate">
                    {{ __('This request has not yet been claimed by a translator') }}
                </div>
                <div>
                    <x-jet-danger-button class="whitespace-nowrap" type="button" wire:click="$toggle('isConfirmingTranslationRequestDeletion')">
                        {{ __('Delete Request') }}
                    </x-jet-danger-button>
                </div>
            @endif
        </div>
    </x-header-action-bar>

    <div class="bg-white p-6 w-full overflow-auto flex-1" wire:key="rich-text-editor" wire:ignore>
        <x-rich-text-editor
            :content="$isViewingTranslation ? $currentTranslationRequest->content : $source->content"
            :isReadOnly="true" />

        @if ($isViewingTranslation)
            <div class="max-w-prose mx-auto">
                <livewire:comment-section :commentable="$currentTranslationRequest" />
            </div>
        @endif
    </div>

    @if (!$isViewingTranslation)
        <x-jet-confirmation-modal wire:model="isConfirmingSourceDeletion">
            <x-slot name="title">
                {{ __('Delete Content') }}
            </x-slot>

            <x-slot name="content">
                {!! __('Are you sure you want to delete :sourceTitle and all of its translation requests?', [
                    'sourceTitle' => '<strong>'.htmlentities($source->title).'</strong>',
                ]) !!}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('isConfirmingSourceDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteSource" wire:loading.attr="disabled">
                    {{ __('Yes') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @elseif ($currentTranslationRequest->isClaimed())
        <x-jet-confirmation-modal wire:model="isConfirmingClaimRevocation">
            <x-slot name="title">
                {{ __('Revoke Claim') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to revoke :translatorName\'s claim on this translation request?', [
                    'translatorName' => ($currentTranslationRequest->translator ?? $deletedUser)->name,
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
    @else
        <x-jet-confirmation-modal wire:model="isConfirmingTranslationRequestDeletion">
            <x-slot name="title">
                {{ __('Delete Translation Request') }}
            </x-slot>

            <x-slot name="content">
                {!! __(
                    $currentTranslationRequest->isComplete()
                        ? 'Are you sure you want to delete the :languageName translation for :sourceTitle?'
                        : 'Are you sure you want to delete the :languageName translation request for :sourceTitle?',
                    [
                        'languageName' => '<strong>'.optional($currentTranslationRequest->language)->name.'</strong>',
                        'sourceTitle' => '<strong>'.htmlentities($source->title).'</strong>',
                    ]
                ) !!}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('isConfirmingTranslationRequestDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteTranslationRequest" wire:loading.attr="disabled">
                    {{ __('Yes') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
