<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        @if ($isMine)
            <x-jet-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <x-jet-button>
                        {{ __('Menu') }}
                    </x-jet-button>
                </x-slot>

                <x-slot name="content">
                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="$dispatch('change-tab', 'source')">
                        {{ __('Original Content') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="$dispatch('change-tab', 'discussion')">
                        {{ __('Discussion') }}
                    </x-jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="Livewire.emit('toggleSubmissionModal')">
                        {{ __('Submit Translation') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="Livewire.emit('toggleUnclaimModal')">
                        {{ __('Unclaim') }}
                    </x-jet-dropdown-link>
                </x-slot>
            </x-jet-dropdown>
        @else
            <x-jet-button  @click="Livewire.emit('toggleClaimModal')">
                {{ __('Claim') }}
            </x-jet-button>
        @endcan
    </x-slot>

    @if (!$isMine)
        <x-slot name="aside">
            <x-slot name="asideTitle">
                {{ __('More Info') }}
            </x-slot>

            <div class="bg-white h-full overflow-hidden">
                <div class="px-4 py-5 sm:px-6 flex gap-2 items-end">
                    <x-user-photo class="w-12 h-12 ring-1 ring-gray-300 " :user="$translationRequest->source->author" />
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $translationRequest->source->title }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            {{ $translationRequest->source->author->name }}
                        </p>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('Original language') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $translationRequest->source->language->native_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('Target language') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $translationRequest->language->native_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ __('Time in translation queue') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ trans_choice(
                                    '{1} :count day|[*] :count days',
                                    1 + Carbon\Carbon::now()->diffInDays($translationRequest->updated_at),
                                ) }}
                            </dd>
                        </div>
                        @cannot('claim', $translationRequest)
                            <div class="sm:col-span-2">
                                <x-warning-alert title="{{ __('Claimed translation request limit reached') }}">
                                    {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
                                </x-warning-alert>
                            </div>
                        @else
                            <x-jet-button class="col-span-2 mx-auto justify-center"
                                          type="button"
                                          @click.prevent="Livewire.emit('toggleClaimModal')">
                                {{ __("I'll Translate This!") }}
                            </x-jet-button>
                        @endcannot
                    </dl>
                </div>
            </div>
        </x-slot>
    @endif

    <div class="bg-white flex h-full" x-data="{ tab: 'source' }" @change-tab.window="tab = $event.detail">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-gray-200 w-full">
            <div class="w-full overflow-auto {{ $isMine ? 'flex flex-col flex-1' : 'w-full' }}">
                <div x-show="tab === 'source'" class="flex-1">
                    @if ($isMine)
                        <div class="md:hidden sticky top-0 z-10">
                            <x-header-action-bar>
                                {{ __('Translating to :languageName', [
                                    'languageName' => $translationRequest->language->native_name,
                                ]) }}
                            </x-header-action-bar>
                        </div>
                    @endif

                    <x-rich-text-editor
                        wire:ignore
                        :content="$translationRequest->source->content"
                        :isReadOnly="true" />
                </div>

                <div class="max-w-7xl mx-auto flex-1" x-show="tab === 'discussion'">
                    <livewire:comment-section :commentable="$translationRequest" />
                </div>

                @if ($isMine)
                    <div class="hidden md:flex order-first lg:order-none lg:sticky bottom-0 border-b lg:border-t lg:border-b-0 border-gray-200"
                         x-data="{ tab: 'source' }"
                         @change-tab.window="tab = $event.detail">
                        @if ($isMine)

                            <button class="bg-indigo-500 text-white h-14 flex-1"
                                    @click.prevent="$dispatch('change-tab', 'source')"
                                    x-bind:class="{ 'bg-indigo-500 text-white': tab === 'source', 'bg-gray-100 hover:bg-gray-200': tab !== 'source' }">
                                {{ __('Original Content') }}
                            </button>
                            <button class="h-14 flex-1"
                                    @click.prevent="$dispatch('change-tab', 'discussion')"
                                    x-bind:class="{ 'bg-indigo-500 text-white': tab === 'discussion', 'bg-gray-100 hover:bg-gray-200': tab !== 'discussion' }">
                                {{ __('Discussion') }}
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            @if ($isMine)
                <div class="flex flex-col flex-1 w-full overflow-auto">
                    <div class="mx-auto flex-1 max-w-full">
                        <x-rich-text-editor
                            wire:ignore
                            :content="$translationRequest->content"
                            :isReadOnly="$translationRequest->isComplete()"
                            x-on:change="e => { $wire.saveTranslation(e.detail.content, e.detail.plainText) }" />
                    </div>
                    @if (!$translationRequest->isComplete())
                        <div class="flex items-center justify-between px-2 hidden md:flex sticky bottom-0 bg-gray-100 border-t border-gray-200">
                            <div class="flex gap-2 items-center h-14">
                                <x-heroicon-o-translate class="w-6 h-6" />
                                {{ $translationRequest->language->native_name }}
                            </div>
                            <div class="text-right flex gap-2">
                                <x-jet-danger-button wire:click="$toggle('isConfirmingUnclaim')" type="button">
                                    {{ __('Unclaim') }}
                                </x-jet-danger-button>
                                <x-jet-button wire:click="$toggle('isConfirmingSubmission')" type="button">
                                    {{ __('Submit translation') }}
                                </x-jet-button>
                            </div>
                        </div>

                    @endif
                </div>

                <x-success-toast
                    class="fixed right-4 bottom-4 flex items-center gap-2 hidden"
                    x-data="{ saved: false, timeout: null}"
                    x-init="$el.classList.remove('hidden')"
                    x-show="saved"
                    x-transition:enter="transition-opacity ease-out duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @toast-translation-request-saved.window.debounce.3000ms="saved = true; clearTimeout(timeout); timeout = setTimeout(() => saved = false, 1500)">
                    <x-heroicon-s-cloud-upload class="w-6 h-6" />
                        {{ __('Saved') }}
                </x-success-toast>

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

                <x-jet-dialog-modal wire:model="isConfirmingSubmission">
                    <x-slot name="title">
                        {{ __('Submit Translation') }}
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

                        <x-jet-button class="ml-2" wire:click="submitTranslation" wire:loading.attr="disabled">
                            {{ __('Submit') }}
                        </x-jet-button>
                    </x-slot>
                </x-jet-dialog-modal>
            @else
                <x-jet-dialog-modal wire:model="isConfirmingClaim">
                    <x-slot name="title">
                        {{ __('Claim Translation Request') }}
                    </x-slot>

                    <x-slot name="content">
                        @can('claim', $translationRequest)
                            {{ __('Are you sure you would like to claim this translation request?') }}
                        @else
                            {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
                        @endcan
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('isConfirmingClaim')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        @can('claim', $translationRequest)
                            <x-jet-button class="ml-2" wire:click="claimTranslationRequest" wire:loading.attr="disabled">
                                {{ __('Claim') }}
                            </x-jet-button>
                        @endcan
                    </x-slot>
                </x-jet-dialog-modal>
            @endif
        </div>
    </div>
</div>
