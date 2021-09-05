@push('styles')
    @once
        <link rel="stylesheet" type="text/css" href="{{ mix('css/autocomplete.css') }}" />
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ mix('js/language-picker.js') }}"></script>
    @endonce
@endpush

@php
    if ($attributes->has('wire:model')) {
        $wireModel = $attributes->get('wire:model');
    }
@endphp

<div x-data='{ languages: [], languagePicker: null }'
     x-init="
         @if (isset($wireModel))
             $watch('languages', languages => $wire.set('{{ $wireModel }}', languages.map(l => l.id)));
         @endif
        languages = {{ $defaultLanguages }};
     "
     {{ $attributes->except('wire:model') }}>

    @if (!$attributes->has('wire:model'))
        <template x-for="language in languages">
            <input
                name="{{ $attributes->get('name').'[]' }}"
                type="hidden"
                x-bind:value="language.id"
            />
        </template>
    @endif

    <div wire:ignore
         x-init="languagePicker = new window.LanguagePicker({
             el: $el,
             onSelect(l, setChosenLanguages) {
                 languages.push(l)
                 setChosenLanguages(languages)
             },
             noResults: '{{ __('No languages found') }}',
             languages: {{ $languages->toJson() }},
             displayTranslatedLanguageName: {{ $shouldDisplayTranslatedLanguage ? 'true' : 'false' }},
         });
         languagePicker.setChosenLanguages({{ $defaultLanguages }})
         ">
    </div>

    <ul class="flex flex-wrap gap-2 mt-2" x-show="languages.length > 0">
        <template x-for="language in languages">
            <li class="bg-gray-200 flex gap-2 px-2 py-1 rounded">
                <span x-text="language.code.toLocaleUpperCase()"></span>
                <button type="button"
                        @click="
                            languages = languages.filter(l => l.id !== language.id);
                            languagePicker.setChosenLanguages(languages)
                        ">
                    &times;
                </button>
            </li>
        </template>
    </ul>
</div>
