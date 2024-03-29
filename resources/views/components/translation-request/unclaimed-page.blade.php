<div class="flex h-full flex-col bg-white">
  <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

  <x-slot name="picker">
    <x-button @click="Livewire.dispatch('toggleClaimModal')">
      {{ __('Claim') }}
    </x-button>
  </x-slot>

  <x-slot name="aside">
    <x-slot name="asideTitle">
      {{ __('More Info') }}
    </x-slot>

    <div class="h-full overflow-hidden bg-white">
      <div class="flex items-start gap-2 px-4 py-5 sm:px-6">
        <x-user-photo class="h-12 w-12" :user="$translationRequest->source->author" />
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
            <x-button class="col-span-2 mx-auto justify-center" type="button"
              @click.prevent="Livewire.dispatch('toggleClaimModal')">
              {{ __("I'll translate this!") }}
            </x-button>
          @else
            <div class="sm:col-span-2">
              @if (Auth::user()->hasVerifiedEmail())
                <x-alert title="{{ __('Claimed translation request limit reached') }}" type="warning"
                  icon="o-exclamation-triangle">
                  {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
                </x-alert>
              @else
                <x-alert title="{{ __('Email verification required') }}" type="warning" icon="o-exclamation-triangle">
                  {{ __('Before being able to translate content, you must verify your email address.') }}
                  <form method="POST" action="{{ route('verification.send') }}" class="mt-2">
                    @csrf
                    <input type="hidden" name="_method" value="POST" />

                    <x-button element="a" href="{{ route('verification.send') }}" class="w-full justify-center"
                      x-data="" @click.prevent="$el.closest('form').submit();">
                      {{ __('Resend verification email') }}
                    </x-button>
                  </form>
                </x-alert>
              @endif
            </div>
          @endcannot
        </dl>
      </div>
    </div>
  </x-slot>

  <div class="flex h-full bg-white">
    <div class="flex w-full flex-col divide-y divide-brand-brown-200 lg:flex-row lg:divide-x lg:divide-y-0">
      <div class="flex w-full flex-1 flex-col overflow-hidden">
        <div class="h-full overflow-auto">
          <div class="flex-1">
            <x-rich-text-editor :content="$translationRequest->source->content" :isReadOnly="true" />
          </div>
        </div>
      </div>

      <x-dialog-modal wire:model.live="isConfirmingClaim">
        <x-slot name="title">
          {{ __('Claim Translation Request') }}
        </x-slot>

        <x-slot name="content">
          @can('claim', $translationRequest)
            {{ __('Are you sure you would like to claim this translation request?') }}
          @elseif (!Auth::user()->hasVerifiedEmail())
            {{ __('Before being able to translate content, you must verify your email address.') }}
            <form method="POST" action="{{ route('verification.send') }}" class="mt-2">
              @csrf
              <input type="hidden" name="_method" value="POST" />

              <x-button element="a" href="{{ route('verification.send') }}" class="w-full justify-center"
                x-data="" @click.prevent="$el.closest('form').submit();">
                {{ __('Resend verification email') }}
              </x-button>
            </form>
          @else
            {{ __('You have reached the claimed translation request limit. Please finish your claimed requests before attempting to claim more.') }}
          @endcan
        </x-slot>

        <x-slot name="footer">
          <x-secondary-button wire:click="toggleClaimModal" wire:loading.attr="disabled">
            {{ __('Cancel') }}
          </x-secondary-button>

          @can('claim', $translationRequest)
            <x-button class="ml-2" wire:click="claimTranslationRequest" wire:loading.attr="disabled">
              {{ __('Claim') }}
            </x-button>
          @endcan
        </x-slot>
      </x-dialog-modal>
    </div>
  </div>
</div>
