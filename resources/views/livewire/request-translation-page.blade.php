<div class="bg-white h-full flex flex-col">
    <x-slot name="sidebar">
    </x-slot>

    <x-slot name="aside">
        <x-slot name="asideTitle">
            {{ __('More Info') }}
        </x-slot>

        <div class="bg-white h-full overflow-hidden">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Submit content for translation') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ __("Enter your content into the editor. Make sure that it's formatted the way you'd like before submitting it.") }}
                </p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                {{ __('Once your content is submitted, it will be available for translators to get to work on it. You will receive notifications to keep you updated on the status of your translations.') }}
            </div>
        </div>
    </x-slot>

    <div class="flex-1 overflow-auto">
        <x-rich-text-editor
            class="px-8"
            wire:ignore
            x-on:change="e => { $wire.set('content', e.detail.content); $wire.set('plainText', e.detail.plainText) }" />
    </div>

    <div class="text-right m-2">
        <x-jet-button
            type="submit"
            wire:click="$set('shouldDisplayLanguagePicker', true)"
            :disabled="mb_strlen(trim($plainText)) === 0"
        >
            {{ __('Continue') }}
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
                            {{ $language->fullName }}
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
                    :shouldDisplayTranslatedLanguage="true"
                    :languages="$languages" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                type="button"
                wire:click="$set('shouldDisplayLanguagePicker', false)"
            >
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button
                type="submit"
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
