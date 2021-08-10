<div class="bg-white h-full flex flex-col">
    <x-rich-text-editor
        wire:ignore
        x-on:change="e => { $wire.set('content', e.detail.content); $wire.set('plainText', e.detail.plainText) }" />

    <div class="text-right m-2">
        <x-jet-button
            wire:click="$set('shouldDisplayLanguagePicker', true)"
            :disabled="mb_strlen(trim($plainText)) === 0"
        >
            {{ __('Submit translation request') }}
        </x-jet-button>
    </div>

    <x-jet-dialog-modal wire:model="shouldDisplayLanguagePicker">
        <x-slot name="title">
            {{ __('Choose languages') }}
        </x-slot>

        <x-slot name="content">
            <x-jet-validation-errors class="mb-4" />

            <div>
                <x-jet-label for="title" class="mb-1">
                    {{ __('Title') }}
                </x-jet-label>
                <x-jet-input id="title" type="text" wire:model.lazy="title" class="w-full" />
            </div>

            <div class="mt-4">
                <x-jet-label for="source-language" class="mb-1">
                    {{ __('Which language is your content written in?') }}
                </x-jet-label>

                <x-jet-select id="source-language" wire:model="sourceLanguageId" class="w-full">
                    @foreach ($languages as $language)
                        <x-jet-option value="{{ $language->id }}">
                            {{ $language->name }} ({{ $language->native_name }})
                        </x-jet-option>
                    @endforeach
                </x-jet-select>
            </div>

            <div class="mt-4">
                <x-jet-label for="language-picker" class="mb-1">
                    {{ __('Which languages would you like your content to be translated to?') }}
                </x-jet-label>
                <x-language-picker
                    id="language-picker"
                    wire:model="targetLanguages"
                    :languages="$languages" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                wire:click="$set('shouldDisplayLanguagePicker', false)"
            >
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button
                class="ml-2"
                dusk="confirm-password-button"
                wire:click="requestTranslation"
                wire:loading.attr="disabled"
                :disabled="count($targetLanguages) === 0"
            >
                {{ __('Submit') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
