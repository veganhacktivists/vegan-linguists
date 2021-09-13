@php
if ($attributes->has('wire:model')) {
    $wireModel = $attributes->get('wire:model');
}
@endphp

<div x-data='{ languages: [], languagePicker: null }'
    x-init="
        @if (isset($wireModel))
            @if ($multiSelect)
                $watch('languages', languages => $wire.set('{{ $wireModel }}', languages.map(l => l.id)));
            @else
                $watch('languages', (languages) => {
                    $wire.set('{{ $wireModel }}', languages.length ? languages[0].id : null);
                    @if (!$multiSelect)
                        if (languages.length > 0) {
                            languagePicker.setInputText(
                                {{ $shouldDisplayTranslatedLanguage ? '`${languages[0].name} (${languages[0].native_name})`' : 'languages[0].native_name' }}
                            );
                        }
                    @endif
                });
            @endif
        @endif
        languages = {{ $defaultLanguages }};
    "
    {{ $attributes->except(['wire:model', 'id']) }}>

    @if (!$attributes->has('wire:model'))
        <template x-for="language in languages">
            <input name="{{ $attributes->get('name') . '[]' }}" type="hidden" x-bind:value="language.id" />
        </template>
    @endif

    <x-jet-input
        wire:ignore
        class="w-full"
        type="text"
        id="{{ $attributes->get('id') }}"
        x-init="languagePicker = new window.LanguagePicker({
             el: $el,
             onSelect(l, setChosenLanguages, setInputText) {
                 {{ $multiSelect ? 'languages.push(l)' : 'languages = [l]' }};
                 {{ $multiSelect ? 'setInputText(``)' : ($shouldDisplayTranslatedLanguage ? 'setInputText(`${l.name} (${l.native_name})`)' : 'setInputText(l.native_name)') }};
                 setChosenLanguages(languages);
             },
             emptyMessage: '{{ __('No languages found') }}',
             languages: {{ $languages->toJson() }},
             displayTranslatedLanguageName: {{ $shouldDisplayTranslatedLanguage ? 'true' : 'false' }},
         });
         languagePicker.setChosenLanguages({{ $defaultLanguages }})
         "
         @blur="languages = languages.slice()" />

    @if ($multiSelect)
        <ul class="flex flex-wrap gap-2 mt-2" x-show="languages.length > 0">
            <template x-for="language in languages">
                <li class="bg-gray-200 flex gap-2 px-2 py-1 rounded">
                    <span x-text="language.code.toLocaleUpperCase()"></span>
                    <button type="button"
                        @click="languages = languages.filter(l => l.id !== language.id); languagePicker.setChosenLanguages(languages)">
                        &times;
                    </button>
                </li>
            </template>
        </ul>
    @endif
</div>
