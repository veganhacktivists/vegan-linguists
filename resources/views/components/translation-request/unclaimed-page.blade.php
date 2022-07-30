<div class="bg-white h-full flex flex-col">
    <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

    <x-slot name="picker">
        <x-jet-button @click="Livewire.emit('toggleClaimModal')">
            {{ __('Claim') }}
        </x-jet-button>
    </x-slot>

    <x-slot name="aside">
        <x-slot name="asideTitle">
            {{ __('More Info') }}
        </x-slot>

        <div class="bg-white h-full overflow-hidden">
            <div class="px-4 py-5 sm:px-6 flex gap-2 items-start">
                <x-user-photo class="w-12 h-12"
                              :user="$translationRequest->source->author" />
                <div>
                    <h3 class="text-lg leading-6 [word-break:break-word]">
                        {{ $translationRequest->source->title }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-brand-brown-600">
                        {{ $translationRequest->source->author->name }}
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
                    <div class="sm:col-span-2">
                        <dt class="text-sm text-brand-brown-600">
                            {{ __('Time in translation queue') }}
                        </dt>
                        <dd class="mt-1 text-sm">
                            {{ trans_choice('{1} :count day|[*] :count days', 1 + Carbon\Carbon::now()->diffInDays($translationRequest->created_at)) }}
                        </dd>
                    </div>
                    @can('claim', $translationRequest)
                        <x-jet-button class="col-span-2 mx-auto justify-center"
                                      type="button"
                                      @click.prevent="Livewire.emit('toggleClaimModal')">
                            {{ __("I'll translate this!") }}
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
                                                      class="w-full justify-center"
                                                      x-data=""
                                                      @click="$event.preventDefault(); $el.closest('form').submit();">
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

    <div class="bg-white flex h-full">
        <div class="flex flex-col lg:flex-row divide-y lg:divide-x lg:divide-y-0 divide-brand-brown-200 w-full">
            <div class="flex flex-col flex-1 w-full overflow-hidden">
                <div class="overflow-auto h-full">
                    <div class="flex-1">
                        <x-rich-text-editor :content="$translationRequest->source->content"
                                            :isReadOnly="true" />
                    </div>
                </div>
            </div>

            <x-jet-dialog-modal wire:model="isConfirmingClaim">
                <x-slot name="title">
                    {{ __('Claim Translation Request') }}
                </x-slot>

                <x-slot name="content">
                    @can('claim', $translationRequest)
                        {{ __('Are you sure you would like to claim this translation request?') }}
                    @elseif (!Auth::user()->hasVerifiedEmail())
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
                                            class="w-full justify-center"
                                            x-data=""
                                            @click="$event.preventDefault(); $el.closest('form').submit();">
                                {{ __('Resend verification email') }}
                            </x-jet-button>
                        </form>
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
        </div>
    </div>
</div>
