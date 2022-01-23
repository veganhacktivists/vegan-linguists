<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        <x-jet-button @click="Livewire.emit('toggleStartReviewingModal')">
            {{ __('Start Reviewing') }}
        </x-jet-button>
    </x-slot>

    <x-slot name="aside">
        <x-slot name="asideTitle">
            {{ __('More Info') }}
        </x-slot>

        <div class="bg-white h-full overflow-hidden">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 [word-break:break-word]">
                    {{ $translationRequest->source->title }}
                </h3>
            </div>
            <div class="border-t border-brand-brown-200 px-4 py-5 sm:px-6 flex gap-2 items-start">
                <x-user-photo class="w-12 h-12"
                              :user="$translationRequest->source->author" />
                <div>
                    <h3 class="text-lg leading-6">
                        {{ $translationRequest->source->author->name }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-brand-brown-600">
                        {{ __('Author') }}
                    </p>
                </div>
            </div>
            <div class="border-t border-brand-brown-200 px-4 py-5 sm:px-6 flex gap-2 items-start">
                <x-user-photo class="w-12 h-12"
                              :user="$translationRequest->translator" />
                <div>
                    <h3 class="text-lg leading-6">
                        {{ user($translationRequest->translator)->name }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-brand-brown-600">
                        {{ __('Translator') }}
                    </p>
                </div>
            </div>
            <div class="border-t border-brand-brown-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm text-brand-brown-600">
                            {{ __('Original language') }}
                        </dt>
                        <dd class="mt-1 text-sm">
                            {{ $translationRequest->source->language->native_name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm text-brand-brown-600">
                            {{ __('Target language') }}
                        </dt>
                        <dd class="mt-1 text-sm">
                            {{ $translationRequest->language->native_name }}
                        </dd>
                    </div>
                    @can('claimForReview', $translationRequest)
                        <x-jet-button class="col-span-2 mx-auto justify-center"
                                      type="button"
                                      @click.prevent="Livewire.emit('toggleStartReviewingModal')">
                            {{ __("I'll Review This!") }}
                        </x-jet-button>
                    @else
                        <div class="sm:col-span-2">
                            @if (!Auth::user()->hasVerifiedEmail())

                                <x-alert title="{{ __('Email verification required') }}"
                                         type="warning"
                                         icon="o-exclamation">
                                    {{ __('Before being able to review translations, you must verify your email address.') }}
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

    <div
         class="grid grid-rows-2 xl:grid-rows-none xl:grid-cols-2 h-full divide-y max-h-[calc(100vh-125px)] lg:max-h-[unset] divide-brand-brown-200 xl:divide-x">
        <div class="overflow-auto">
            <x-rich-text-editor :content="$translationRequest->source->content"
                                :isReadOnly="true" />
        </div>
        <div class="overflow-auto">
            <x-rich-text-editor :content="$translationRequest->content"
                                :isReadOnly="true" />
        </div>
    </div>

    <x-jet-dialog-modal wire:model="isConfirmingReview">
        <x-slot name="title">
            {{ __('Start Reviewing Translation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to review this translation?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="toggleStartReviewingModal"
                                    wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2"
                          wire:click="startReviewing"
                          wire:loading.attr="disabled">
                {{ __('Start Review') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
