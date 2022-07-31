@php
$renderItemFunction = $shouldDisplayTranslatedLanguage ? "({ full_name }) => `\${full_name}`" : '({ name }) => name';
@endphp

<x-autocomplete {{ $attributes }} :items="$languages" :defaultItems="$defaultLanguages" :multiSelect="$multiSelect" :emptyMessage="__('No languages found')"
  :renderItem="$renderItemFunction" :renderItemLabel="$renderItemFunction" getItemValue="({ id }) => id" comparator="(text, { code, name, native_name }) => (
                    code.toLocaleLowerCase().includes(text) ||
                    name.toLocaleLowerCase().includes(text) ||
                    native_name.toLocaleLowerCase().includes(text)
                )" />
