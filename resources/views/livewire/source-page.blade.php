<div class="flex h-full flex-col">
  <x-slot name="pageTitle">{{ $source->title }}</x-slot>

  <x-slot name="aside">
    <x-slot name="asideTitle">
      {{ __('Change Language') }}
    </x-slot>

    <div class="overflow-hidden lg:h-full lg:overflow-auto">
      <x-stacked-list>
        <li
          class="{{ $isViewingTranslation ? 'bg-white hover:bg-brand-beige-50' : 'bg-brand-clay-400 text-white font-bold' }}">
          <a href="{{ route('source', [$source->id, $source->slug]) }}" class="block">
            <div class="truncate px-4 py-4 sm:px-6">
              {{ __(':languageName (Original)', ['languageName' => $source->language->native_name]) }}
            </div>
          </a>
        </li>

        @foreach ($source->translationRequests as $translationRequest)
          <li
            class="{{ $translationRequest->is($currentTranslationRequest) ? 'bg-brand-clay-200 font-bold' : 'bg-white hover:bg-brand-clay-50' }}">
            <a href="{{ route('translation', [$source->id, $translationRequest->language->id]) }}"
              class="flex items-center justify-between px-4 py-4 sm:px-6">
              <div class="truncate">
                {{ $translationRequest->language->name }}
                ({{ $translationRequest->language->native_name }})
              </div>
              <div>
                @if ($translationRequest->isComplete())
                  <x-progress-indicator progress="100" data-tooltip="{{ __('Completed') }}" data-tippy-placement="right"
                    class="h-6 w-6" />
                @elseif ($translationRequest->isUnderReview())
                  <x-progress-indicator progress="75" data-tooltip="{{ __('Under Review') }}"
                    data-tippy-placement="right" class="h-6 w-6" />
                @elseif ($translationRequest->isClaimed())
                  <x-progress-indicator progress="50" data-tooltip="{{ __('Translation In Progress') }}"
                    data-tippy-placement="right" class="h-6 w-6" />
                @else
                  <x-progress-indicator progress="25" data-tooltip="{{ __('Submitted For Translation') }}"
                    data-tippy-placement="right" class="h-6 w-6" />
                @endif
              </div>
            </a>
          </li>
        @endforeach
      </x-stacked-list>
    </div>

  </x-slot>

  <x-header-action-bar>
    <div class="flex items-center justify-between gap-2">
      @if (!$isViewingTranslation)
        <div class="truncate">
          {{ $source->title }}
        </div>
        <div>
          <x-danger-button class="whitespace-nowrap" type="button"
            wire:click="$toggle('isConfirmingSourceDeletion')">
            {{ __('Delete content') }}
          </x-danger-button>
        </div>
      @elseif ($currentTranslationRequest->isClaimed())
        <div class="truncate">
          <x-user-photo :user="$currentTranslationRequest->translator" class="mr-2 inline-block h-10 w-10" />

          {{ __(':translatorName has claimed this translation request', [
              'translatorName' => $currentTranslationRequest->translator->name,
          ]) }}
        </div>
        <div>
          <x-danger-button class="whitespace-nowrap" type="button"
            wire:click="$toggle('isConfirmingClaimRevocation')">
            {{ __('Revoke claim') }}
          </x-danger-button>
        </div>
      @elseif ($currentTranslationRequest->isUnderReview())
        <div class="truncate">
          <x-user-photo :user="$currentTranslationRequest->translator" class="mr-2 inline-block h-10 w-10" />

          {{ __(':translatorName\'s translation is currently under review', [
              'translatorName' => user($currentTranslationRequest->translator)->name,
          ]) }}
        </div>
        <div>
          <x-danger-button class="whitespace-nowrap" type="button"
            wire:click="$toggle('isConfirmingTranslationRequestDeletion')">
            {{ __('Delete request') }}
          </x-danger-button>
        </div>
      @elseif ($currentTranslationRequest->isComplete())
        <div class="truncate">
          <x-user-photo :user="$currentTranslationRequest->translator" class="mr-2 inline-block h-10 w-10" />

          {{ __(':translatorName translated this content', [
              'translatorName' => user($currentTranslationRequest->translator)->name,
          ]) }}
        </div>
        <div>
          <x-danger-button class="whitespace-nowrap" type="button"
            wire:click="$toggle('isConfirmingTranslationRequestDeletion')">
            {{ __('Delete translation') }}
          </x-danger-button>
        </div>
      @else
        <div class="truncate">
          {{ __('This request has not yet been claimed by a translator') }}
        </div>
        <div>
          <x-danger-button class="whitespace-nowrap" type="button"
            wire:click="$toggle('isConfirmingTranslationRequestDeletion')">
            {{ __('Delete request') }}
          </x-danger-button>
        </div>
      @endif
    </div>
  </x-header-action-bar>

  <div class="w-full flex-1 overflow-auto bg-white px-6 pb-6" wire:key="rich-text-editor" wire:ignore>
    <x-rich-text-editor class="mt-6" :content="$isViewingTranslation ? $currentTranslationRequest->content : $source->content"
      @highlight-annotation.window="highlight($event.detail.index, $event.detail.length)" :isReadOnly="true" />

    @if ($isViewingTranslation)
      <div class="mx-auto max-w-prose">
        <livewire:comment-section :commentable="$currentTranslationRequest" />
      </div>
    @endif
  </div>

  @if (!$isViewingTranslation)
    <x-confirmation-modal wire:model.live="isConfirmingSourceDeletion">
      <x-slot name="title">
        {{ __('Delete Content') }}
      </x-slot>

      <x-slot name="content">
        {!! __('Are you sure you want to delete :sourceTitle and all of its translation requests?', [
            'sourceTitle' => '<strong>' . htmlentities($source->title) . '</strong>',
        ]) !!}
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('isConfirmingSourceDeletion')" wire:loading.attr="disabled">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ml-2" wire:click="deleteSource" wire:loading.attr="disabled">
          {{ __('Yes') }}
        </x-danger-button>
      </x-slot>
    </x-confirmation-modal>
  @elseif ($currentTranslationRequest->isClaimed())
    <x-confirmation-modal wire:model.live="isConfirmingClaimRevocation">
      <x-slot name="title">
        {{ __('Revoke Claim') }}
      </x-slot>

      <x-slot name="content">
        {{ __('Are you sure you want to revoke :translatorName\'s claim on this translation request?', [
            'translatorName' => user($currentTranslationRequest->translator)->name,
        ]) }}
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('isConfirmingClaimRevocation')" wire:loading.attr="disabled">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ml-2" wire:click="revokeClaim" wire:loading.attr="disabled">
          {{ __('Yes') }}
        </x-danger-button>
      </x-slot>
    </x-confirmation-modal>
  @else
    <x-confirmation-modal wire:model.live="isConfirmingTranslationRequestDeletion">
      <x-slot name="title">
        {{ __('Delete Translation Request') }}
      </x-slot>

      <x-slot name="content">
        {!! __(
            $currentTranslationRequest->isComplete()
                ? 'Are you sure you want to delete the :languageName translation for :sourceTitle?'
                : 'Are you sure you want to delete the :languageName translation request for :sourceTitle?',
            [
                'languageName' => '<strong>' . optional($currentTranslationRequest->language)->name . '</strong>',
                'sourceTitle' => '<strong>' . htmlentities($source->title) . '</strong>',
            ],
        ) !!}
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('isConfirmingTranslationRequestDeletion')"
          wire:loading.attr="disabled">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ml-2" wire:click="deleteTranslationRequest" wire:loading.attr="disabled">
          {{ __('Yes') }}
        </x-danger-button>
      </x-slot>
    </x-confirmation-modal>
  @endif
</div>
