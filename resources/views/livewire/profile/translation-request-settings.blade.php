<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Translation Request Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('These settings apply to content that you submit for translation by others.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="languages"
                         value="{{ __('Which languages do you typically want your content to be translated to?') }}" />
            <x-language-picker id="target-languages"
                               class="mt-1 block"
                               wire:model="targetLanguages"
                               :defaultLanguages="Auth::user()->default_target_languages" />
            <x-jet-input-error for="target-languages"
                               class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3"
                              on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button type="submit"
                      wire:loading.attr="disabled"
                      wire:target="targetLanguages">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
