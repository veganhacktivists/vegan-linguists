<div class="flex h-full flex-col bg-white">
  <x-slot name="pageTitle">{{ __('Request Translation') }}</x-slot>

  <x-slot name="aside">
    <x-slot name="asideTitle">
      {{ __('More Info') }}
    </x-slot>

    <div class="h-full overflow-hidden bg-white">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 text-brand-brown-900">
          {{ __('Submit content for translation') }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-brand-brown-700">
          {{ __("Enter your content into the editor. Make sure that it's formatted the way you'd like before submitting it.") }}
        </p>
      </div>
      <div class="border-t border-brand-brown-200 px-4 py-5 sm:px-6">
        {{ __('Once your content is submitted, it will be available for translators to get to work on it. You will receive notifications to keep you updated on the status of your translations.') }}
      </div>
    </div>
  </x-slot>

  <div class="flex-1 overflow-auto">
    <x-rich-text-editor class="px-8" wireContentModel="content" wirePlainTextModel="plainText" :autoFocus="true"
      :placeholder="__('Type here to get started…')" x-on:change="e => { window.hasChanges = true }" />
  </div>

  <div class="sticky bottom-0 bg-white p-2 text-right">
    <x-jet-button type="submit" wire:click="$set('shouldDisplaySubmissionModal', true)" :disabled="mb_strlen(trim($plainText)) === 0">
      {{ __('Continue') }}
    </x-jet-button>
  </div>

  <x-jet-dialog-modal wire:model="shouldDisplaySubmissionModal">
    <x-slot name="title">
      {{ __('Choose languages') }}
    </x-slot>

    <x-slot name="content">
      <x-jet-validation-errors class="mb-4" />

      <div>
        <x-jet-label for="title" class="mb-1">
          {{ __('Title') }}
        </x-jet-label>
        <x-jet-input id="title" type="text" wire:model.lazy="title" />
      </div>

      <div class="mt-4">
        <x-jet-label for="source-language" class="mb-1">
          {{ __('Which language is your content written in?') }}
        </x-jet-label>

        <x-language-picker id="source-language" resultsClass="z-50" wire:model="sourceLanguageId" :multiSelect="false"
          :defaultLanguages="collect([Auth::user()->languages->first()])" :languages="Auth::user()->languages" />
      </div>

      <div class="mt-4">
        <x-jet-label for="language-picker" class="mb-1">
          {{ __('Which languages would you like your content to be translated to?') }}
        </x-jet-label>
        <x-language-picker id="language-picker" resultsClass="z-50" wire:model="targetLanguages" :shouldDisplayTranslatedLanguage="true"
          :languages="$languages" :defaultLanguages="Auth::user()->default_target_languages" />
      </div>

      <div class="mt-4">
        <x-jet-label for="num-reviewers" class="mb-1">
          {{ __('How many reviewers would you like to review the submitted translations?') }}
        </x-jet-label>
        <x-jet-input id="num-reviewers" type="text" wire:model.lazy="numReviewers" />
      </div>

      <div class="mt-4">
        <x-alert title="{{ __('Important') }}" type="warning" icon="o-exclamation">
          {{ __('Once your submit your content for translation, it cannot be changed.') }}
          <strong>
            {{ __('Please make sure to proofread your content thoroughly before submission.') }}
          </strong>
        </x-alert>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-jet-secondary-button type="button" wire:click="$set('shouldDisplaySubmissionModal', false)">
        {{ __('Cancel') }}
      </x-jet-secondary-button>

      <x-jet-button type="submit" class="ml-2" dusk="confirm-password-button" @click="window.hasChanges = false"
        wire:click="requestTranslation" wire:loading.attr="disabled" :disabled="count($targetLanguages) === 0">
        {{ __('Submit') }}
      </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>

  <script nonce="{{ csp_nonce() }}">
    (function() {
      window.hasChanges = false;

      const confirmLeave = function(e) {
        if (window.hasChanges) {
          e.preventDefault();
          e.returnValue = '';
        } else {
          window.removeEventListener("beforeunload", confirmLeave);
        }
      };

      const confirmNavigation = function(e) {
        if (window.hasChanges && !confirm({!! json_encode(__('Are you sure you want to leave this page? You have unsaved changes.')) !!})) {
          e.preventDefault();
        } else {
          window.removeEventListener("beforeunload", confirmLeave);
        }
      };

      window.addEventListener("beforeunload", confirmLeave);
    })()
  </script>
</div>
