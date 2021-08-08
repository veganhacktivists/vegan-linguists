@once('scripts')
<script src="{{ mix('js/language-picker.js') }}"></script>
@endonce

<div x-data='{ languages: {!! $defaultLanguages !!} }'>
    <template x-for="languageId in languages">
        <input
            name="{{ $attributes->get('name').'[]' }}"
            type="hidden"
            x-bind:value="languageId"
        />
    </template>

    <x-jet-input
        {{ $attributes->except('name')->merge([
            'type' => 'text',
            'list' => 'available-languages',
        ]) }}
        @change="window.LanguagePicker.addLanguage($el, languages)"
    />

    <ul class="flex flex-wrap gap-2 mt-2" x-show="languages.length > 0">
        <template x-for="languageId in languages">
            <li class="bg-gray-200 flex gap-2 px-2 py-1 rounded">
                <span x-text="window.LanguagePicker.getLanguageCode(languageId)"></span>
                <button type="button" @click="languages = languages.filter(id => id !== languageId)">
                    &times;
                </button>
            </li>
        </template>
    </ul>

    <datalist id="available-languages" class="h-6">
        @foreach ($languages as $language)
            <option
                x-bind:disabled="languages.includes('{{ $language->id }}')"
                data-id="{{ $language->id }}"
                data-code="{{ $language->code }}"
                value="{{ $language->name }} ({{ $language->native_name }})" />
        @endforeach
    </datalist>
</div>
