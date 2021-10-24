<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        @if ($isMine)
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
                        {{ __('Original Content') }}
                    </x-jet-dropdown-link>

                    <x-jet-dropdown-link href="#"
                                         aria-role="button"
                                         @click.prevent="$dispatch('change-tab', 'discussion')">
                        {{ __('Discussion') }}
                    </x-jet-dropdown-link>

                    <div class="border-t border-brandBrown-200"></div>

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
            <x-jet-button @click="Livewire.emit('toggleClaimModal')">
                {{ __('Claim') }}
            </x-jet-button>
        @endif
    </x-slot>

    @if (!$isMine)
        <x-slot name="aside">
            <x-slot name="asideTitle">
                {{ __('More Info') }}
            </x-slot>

            <div class="bg-white h-full overflow-hidden">
                <div class="px-4 py-5 sm:px-6 flex gap-2 items-end">
                    <x-user-photo class="w-12 h-12"
                                  :user="$translationRequest->source->author" />
                    <div>
                        <h3 class="text-lg leading-6">
                            {{ $translationRequest->source->title }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-brandBrown-600">
                            {{ $translationRequest->source->author->name }}
                        </p>
                    </div>
                </div>
                <div class="border-t border-brandBrown-200 px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm text-brandBrown-600">
                                {{ __('Original language') }}
                            </dt>
                            <dd class="mt-1 text-sm">
                                {{ $translationRequest->source->language->native_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm text-brandBrown-600">
                                {{ __('Target language') }}
                            </dt>
                            <dd class="mt-1 text-sm">
                                {{ $translationRequest->language->native_name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm text-brandBrown-600">
                                {{ __('Time in translation queue') }}
                            </dt>
                            <dd class="mt-1 text-sm">
                                {{ trans_choice('{1} :count day|[*] :count days', 1 + Carbon\Carbon::now()->diffInDays($translationRequest->updated_at)) }}
                            </dd>
                        </div>
                        @can('claim', $translationRequest)
                            <x-jet-button class="col-span-2 mx-auto justify-center"
                                          type="button"
                                          @click.prevent="Livewire.emit('toggleClaimModal')">
                                {{ __("I'll Translate This!") }}
                            </x-jet-button>
                        @else
                            <div class="sm:col-span-2">
                                @if (Auth::user()->hasVerifiedEmail())
                                    <x-alert title="{{ __('Claimed translation request limit reached') }}"
                                             type="warning"
                                             icon="o-exclamation">
                                        {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
                                    </x-alert>
                                @else
                                    <x-alert title="{{ __('Email verification required') }}"
                                             type="warning"
                                             icon="o-exclamation">
                                        {{ __('Before being able to translate content, you must verify your email address.') }}
                                        <form method="POST"
                                              action="{{ route('verification.send') }}"
                                              class="mt-2">
                                            @csrf
                                            <input type="hidden"
                                                   name="_method"
                                                   value="POST" />

                                            <x-jet-button element="a"
                                                          href="{{ route('verification.send') }}"
                                                          onclick="event.preventDefault(); this.closest('form').submit();"
                                                          class="w-full justify-center">
                                                {{ __('Resend verification email') }}
                                            </x-jet-button>
                                        </form>
                                    </x-alert>
                                @endif
                            </div>
                        @endcannot
                    </dl>
                </div>
            </div>
        </x-slot>
    @endif

    <div class="bg-white flex h-full"
         x-data="{ tab: 'source' }"
         @change-tab.window="tab = $event.detail">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-brandBrown-200 w-full">
            <div class="w-full overflow-auto {{ $isMine ? 'flex flex-col flex-1' : 'w-full' }}">
                <div x-show="tab === 'source'"
                     class="flex-1">
                    @if ($isMine)
                        <div class="md:hidden sticky top-0 z-10">
                            <x-header-action-bar>
                                {{ __('Translating to :languageName', [
    'languageName' => $translationRequest->language->native_name,
]) }}
                            </x-header-action-bar>
                        </div>
                    @endif

                    <x-rich-text-editor :content="$translationRequest->source->content"
                                        :isReadOnly="true" />
                </div>

                <div class="max-w-7xl mx-auto flex-1"
                     x-show="tab === 'discussion'">
                    <livewire:comment-section :commentable="$translationRequest" />
                </div>

                @if ($isMine)
                    <div class="hidden md:flex order-first lg:order-none lg:sticky bottom-0 border-b lg:border-t lg:border-b-0 border-brandBrown-200"
                         x-data="{ tab: 'source' }"
                         @change-tab.window="tab = $event.detail">
                        @if ($isMine)

                            <button class="bg-brandClay-400 font-bold text-white h-14 flex-1"
                                    @click.prevent="$dispatch('change-tab', 'source')"
                                    x-bind:class="{ 'bg-brandClay-400 font-bold text-white': tab === 'source', 'bg-brandBeige-50 hover:bg-brandBeige-100': tab !== 'source' }">
                                {{ __('Original Content') }}
                            </button>
                            <button class="h-14 flex-1"
                                    @click.prevent="$dispatch('change-tab', 'discussion')"
                                    x-bind:class="{ 'bg-brandClay-400 font-bold text-white': tab === 'discussion', 'bg-brandBeige-50 hover:bg-brandBeige-100': tab !== 'discussion' }">
                                {{ __('Discussion') }}
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            @if ($isMine)
                <div class="flex flex-col flex-1 w-full overflow-auto">
                    <div class="mx-auto flex-1 max-w-full">
                        <x-rich-text-editor :content="$translationRequest->content"
                                            :isReadOnly="$translationRequest->isComplete()"
                                            x-on:change="e => { $wire.saveTranslation(e.detail.content, e.detail.plainText) }" />
                    </div>
                    @if (!$translationRequest->isComplete())
                        <div
                             class="flex items-center justify-between px-2 md:flex sticky bottom-0 bg-brandBeige-50 border-t border-brandBrown-200">
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

                <x-success-toast class="fixed right-4 bottom-16 flex items-center gap-2 hidden"
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
                            {{ __(' Make sure you are finished, because this cannot be undone.') }}
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
                        <x-jet-secondary-button wire:click="toggleClaimModal"
                                                wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        @can('claim', $translationRequest)
                            <x-jet-button class="ml-2"
                                          wire:click="claimTranslationRequest"
                                          wire:loading.attr="disabled">
                                {{ __('Claim') }}
                            </x-jet-button>
                        @endcan
                    </x-slot>
                </x-jet-dialog-modal>
            @endif
        </div>
    </div>
</div>
