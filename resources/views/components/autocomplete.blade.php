@props(['items', 'comparator', 'renderItem', 'renderItemLabel', 'getItemValue', 'emptyMessage', 'defaultItems' => collect(), 'multiSelect' => true, 'resultsClass' => 'z-10'])

@php($wireModel = $attributes->get('wire:model', null))

<div x-data="autocomplete({
    input: $refs.input,
    emptyMessage: {{ json_encode($emptyMessage) }},
    items: {{ json_encode($items) }},
    comparator: {!! $comparator !!},
    renderItem: {!! $renderItem !!},
    renderItemLabel: {!! $renderItemLabel !!},
    getItemValue: {!! $getItemValue !!},
    defaultItems: {{ json_encode($defaultItems) }},
    multiSelect: {{ $multiSelect ? 'true' : 'false' }},
    wireModel: {{ json_encode($wireModel) }},
    resultsClass: {{ json_encode($resultsClass) }},
})"
     wire:ignore
     {{ $attributes->except(['wire:model', 'id', 'x-data']) }}>

    @if (empty($wireModel))
        <template x-for="item in selectedItems">
            <input name="{{ $attributes->get('name') . ($multiSelect ? '[]' : '') }}"
                   type="hidden"
                   x-bind:value="getItemValue(item)" />
        </template>
    @endif

    <x-jet-input id="{{ $attributes->get('id') }}"
                 type="text"
                 x-ref="input"
                 autocomplete="off"
                 @blur="attemptToSelectItem()" />

    @if ($multiSelect)
        <ul class="flex flex-wrap gap-2 mt-2"
            x-show="selectedItems.length > 0">
            <template x-for="item in selectedItems">
                <li class="bg-brandBlue-50 border border-brandBlue-200 flex gap-2 px-2 py-1 rounded">
                    <span x-text="renderItemLabel(item)"></span>
                    <button type="button"
                            @click="unselect(item)">
                        &times;
                    </button>
                </li>
            </template>
        </ul>
    @endif
</div>
