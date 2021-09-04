<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="sidebar">
        <div x-data="{ tab: 'source' }">
            @if ($isMine)
                <x-sidebar-link href="#"
                                icon="o-document-text"
                                aria-role="button"
                                @click.prevent="tab = 'source'"
                                x-bind:class="{ active: tab === 'source' }" :active="true">
                    {{ __('Original content') }}
                </x-sidebar-link>
                <x-sidebar-link href="#"
                                icon="o-annotation"
                                aria-role="button"
                                @click.prevent="tab = 'discussion'; alert('Coming soon')"
                                x-bind:class="{ active: tab === 'discussion' }">
                    {{ __('Discussion') }}
                </x-sidebar-link>
            @else
                <x-sidebar-link href="#" icon="o-pencil" aria-role="button" @click.prevent="Livewire.emit('toggleClaimModal')">
                    {{ __('Claim Translation Request') }}
                </x-sidebar-link>
            @endcan
        </div>
    </x-slot>

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
                                         @click.prevent="">
                        {{ __('Original content') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="alert('Coming soon')">
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
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $translationRequest->source->title }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ $translationRequest->source->author->name }}
                    </p>
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
                        @endcannot
                    </dl>
                </div>
            </div>
        </x-slot>
    @endif

    <div class="bg-white flex h-full">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-gray-200 w-full">
            <div class="w-full overflow-auto {{ $isMine ? 'flex-1' : 'w-full' }}">
                <x-rich-text-editor
                    wire:ignore
                    :content="$translationRequest->source->content"
                    :isReadOnly="true" />
            </div>

            @if ($isMine)
                <div class="flex flex-col flex-1 w-full overflow-auto">
                    <div class="mx-auto flex-1">
                        <x-rich-text-editor
                            wire:ignore
                            :content="$translationRequest->content"
                            :isReadOnly="$translationRequest->isComplete()"
                            x-on:change="e => { $wire.saveTranslation(e.detail.content, e.detail.plainText) }" />
                    </div>
                    <div class="text-right p-2 hidden md:block flex gap-2 sticky bottom-0 bg-white">
                        <x-jet-danger-button wire:click="$toggle('isConfirmingUnclaim')" type="button">
                            {{ __('Unclaim') }}
                        </x-jet-danger-button>
                        <x-jet-button wire:click="$toggle('isConfirmingSubmission')" type="button">
                            {{ __('Submit translation') }}
                        </x-jet-button>
                    </div>
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

                <x-jet-confirmation-modal wire:model="isConfirmingSubmission">
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
                </x-jet-confirmation-modal>
            @else
                <x-jet-confirmation-modal wire:model="isConfirmingClaim">
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
                </x-jet-confirmation-modal>
            @endif
        </div>
    </div>
</div>
