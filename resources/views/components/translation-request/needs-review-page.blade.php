<div class="flex h-full flex-col bg-white">
  <x-slot name="pageTitle">{{ $translationRequest->source->title }}</x-slot>

  <x-slot name="picker">
    <x-button @click="Livewire.emit('toggleStartReviewingModal')">
      {{ __('Start reviewing') }}
    </x-button>
  </x-slot>

  <x-slot name="aside">
    <x-slot name="asideTitle">
      {{ __('More Info') }}
    </x-slot>

    <div class="h-full overflow-hidden bg-white">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 [word-break:break-word]">
          {{ $translationRequest->source->title }}
        </h3>
      </div>
      <div class="flex items-start gap-2 border-t border-brand-brown-200 px-4 py-5 sm:px-6">
        <x-user-photo class="h-12 w-12" :user="$translationRequest->source->author" />
        <div>
          <h3 class="text-lg leading-6">
            {{ $translationRequest->source->author->name }}
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-brand-brown-600">
            {{ __('Author') }}
          </p>
        </div>
      </div>
      <div class="flex items-start gap-2 border-t border-brand-brown-200 px-4 py-5 sm:px-6">
        <x-user-photo class="h-12 w-12" :user="$translationRequest->translator" />
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
            <x-button class="col-span-2 mx-auto justify-center" type="button"
              @click.prevent="Livewire.emit('toggleStartReviewingModal')">
              {{ __("I'll review this!") }}
            </x-button>
          @else
            <div class="sm:col-span-2">
              @if (!Auth::user()->hasVerifiedEmail())
                <x-alert title="{{ __('Email verification required') }}" type="warning" icon="o-exclamation-triangle">
                  {{ __('Before being able to review translations, you must verify your email address.') }}
                  <form method="POST" action="{{ route('verification.send') }}" class="mt-2">
                    @csrf
                    <input type="hidden" name="_method" value="POST" />

                    <x-button element="a" class="w-full justify-center" href="{{ route('verification.send') }}"
                      x-data="" @click.prevent="$el.closest('form').submit();">
                      {{ __('Resend verification email') }}
                    </x-button>
                  </form>
                </x-alert>
              @endif
            </div>
          @endcan
        </dl>
      </div>
    </div>
  </x-slot>

  <div
    class="grid h-full max-h-[calc(100vh-125px)] grid-rows-2 divide-y divide-brand-brown-200 lg:max-h-[unset] xl:grid-cols-2 xl:grid-rows-none xl:divide-x">
    <div class="overflow-auto">
      <x-rich-text-editor :content="$translationRequest->source->content" :isReadOnly="true" />
    </div>
    <div class="overflow-auto">
      <x-rich-text-editor :content="$translationRequest->content" :isReadOnly="true" />
    </div>
  </div>

  <x-dialog-modal wire:model.live="isConfirmingReview">
    <x-slot name="title">
      {{ __('Start Reviewing Translation') }}
    </x-slot>

    <x-slot name="content">
      @can('claimForReview', $translationRequest)
        {{ __('Are you sure you would like to review this translation?') }}
      @else
        @if (!Auth::user()->hasVerifiedEmail())
          {{ __('Before being able to review translations, you must verify your email address.') }}
          <form method="POST" action="{{ route('verification.send') }}" class="mt-2">
            @csrf
            <input type="hidden" name="_method" value="POST" />

            <x-button element="a" class="w-full justify-center" href="{{ route('verification.send') }}"
              x-data="" @click.prevent="$el.closest('form').submit();">
              {{ __('Resend verification email') }}
            </x-button>
          </form>
        @endif
      @endcan
    </x-slot>

    <x-slot name="footer">
      <x-secondary-button wire:click="toggleStartReviewingModal" wire:loading.attr="disabled">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-button class="ml-2" wire:click="startReviewing" wire:loading.attr="disabled">
        {{ __('Start review') }}
      </x-button>
    </x-slot>
  </x-dialog-modal>
</div>
