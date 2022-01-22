<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        <x-jet-dropdown align="left"
                        width="48">
            <x-slot name="trigger">
                <x-jet-button>
                    {{ __('Menu') }}
                </x-jet-button>
            </x-slot>

            <x-slot name="content">
                <x-jet-dropdown-link href="#"
                                     aria-role="button"
                                     @click.prevent="$dispatch('change-tab', 'source')">
                    {{ __('Original content') }}
                </x-jet-dropdown-link>

                <x-jet-dropdown-link href="#"
                                     aria-role="button"
                                     @click.prevent="$dispatch('change-tab', 'discussion')">
                    {{ __('Discussion') }}
                </x-jet-dropdown-link>

                @if ($translationRequest->isClaimed())
                    <div class="border-t border-brand-brown-200"></div>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="Livewire.emit('toggleSubmissionModal')">
                        {{ __('Submit translation') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="Livewire.emit('toggleUnclaimModal')">
                        {{ __('Unclaim') }}
                    </x-jet-dropdown-link>
                @endif
            </x-slot>
        </x-jet-dropdown>
    </x-slot>

    <div class="bg-white flex h-full"
         x-data="{ tab: window.location.hash === '#discussion' ? 'discussion' : 'source' }"
         @change-tab.window="
            tab = $event.detail;
            history.replaceState(null, null, window.location.pathname + ('#' + tab).replace('#source', ''));
         ">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-brand-brown-200 w-full">
            <div class="flex flex-col flex-1 w-full overflow-hidden">
                <div class="overflow-auto h-full">
                    <div x-show="tab === 'source'"
                         class="flex-1">
                        <div class="md:hidden sticky top-0 z-10">
                            <x-header-action-bar>
                                @if ($translationRequest->isUnderReview())
                                    {{ __('This translation is currently under review.') }}
                                @else
                                    {{ __('Translating to :languageName', ['languageName' => $translationRequest->language->native_name]) }}
                                @endif
                            </x-header-action-bar>
                        </div>

                        <x-rich-text-editor :content="$translationRequest->source->content"
                                            :isReadOnly="true" />
                    </div>

                    <div class="max-w-7xl mx-auto flex-1"
                         x-show="tab === 'discussion'">
                        <livewire:comment-section :commentable="$translationRequest" />
                    </div>
                </div>
                <div
                     class="hidden md:flex order-first lg:order-none border-b lg:border-t lg:border-b-0 border-brand-brown-200">
                    <button class="bg-brand-clay-400 font-bold text-white h-14 flex-1"
                            @click.prevent="$dispatch('change-tab', 'source')"
                            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab === 'source', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'source' }">
                        {{ __('Original Content') }}
                    </button>
                    <button class="h-14 flex-1"
                            @click.prevent="$dispatch('change-tab', 'discussion')"
                            x-bind:class="{ 'bg-brand-clay-400 font-bold text-white': tab === 'discussion', 'bg-brand-beige-50 hover:bg-brand-beige-100': tab !== 'discussion' }">
                        {{ __('Discussion') }}
                    </button>
                </div>
            </div>

            <div class="flex flex-col flex-1 w-full overflow-hidden z-20">
                <div class="overflow-auto h-full">
                    <div class="mx-auto flex-1 max-w-full">
                        <x-rich-text-editor :content="$translationRequest->content"
                                            :isReadOnly="$translationRequest->isComplete()"
                                            @highlight-annotation.window="highlight($event.detail.index, $event.detail.length)"
                                            x-on:change="e => { $wire.saveTranslation(e.detail.content, e.detail.plainText) }" />
                    </div>
                </div>
                <div
                     class="hidden md:flex items-center justify-between px-2 bg-brand-beige-50 border-t border-brand-brown-200">
                    @if ($translationRequest->isUnderReview())
                        <div class="flex items-center justify-center w-full h-14">
                            {{ __('This translation is currently under review.') }}
                        </div>
                    @else
                        <div class="flex gap-2 items-center h-14">
                            <x-heroicon-o-translate class="w-6 h-6" />
                            {{ $translationRequest->language->native_name }}
                        </div>
                        <div class="text-right flex gap-2">
                            <x-jet-danger-button wire:click="toggleUnclaimModal"
                                                 type="button">
                                {{ __('Unclaim') }}
                            </x-jet-danger-button>
                            <x-jet-button wire:click="toggleSubmissionModal"
                                          type="button">
                                {{ __('Submit translation') }}
                            </x-jet-button>
                        </div>
                </div>
                @endif
            </div>

            <x-success-toast class="fixed right-4 bottom-16 items-center gap-2 hidden"
                             x-data="{ saved: false, timeout: null}"
                             x-init="$el.classList.remove('hidden'); $el.classList.add('flex')"
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
                    <x-jet-secondary-button wire:click="toggleUnclaimModal"
                                            wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2"
                                         wire:click="unclaimTranslationRequest"
                                         wire:loading.attr="disabled">
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
                        {{ __('Make sure you are finished, because this cannot be undone.') }}
                    </strong>

                    <x-jet-validation-errors class="mt-3" />
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="toggleSubmissionModal"
                                            wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-2"
                                  wire:click="submitTranslation"
                                  wire:loading.attr="disabled">
                        {{ __('Submit') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
        </div>
    </div>
</div>
