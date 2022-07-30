@props(['content' => '{}', 'isReadOnly' => false, 'disableStyles' => false, 'autoFocus' => false, 'wireContentModel' => null, 'wirePlainTextModel' => null, 'inlineToolbar' => null, 'placeholder' => ''])

<div x-data="richTextEditor({
    readonly: {{ $isReadOnly ? 'true' : 'false' }},
    autofocus: {{ $autoFocus ? ' true' : 'false' }},
    content: {{ html_entity_decode($content) }},
    wireContentModel: {{ json_encode($wireContentModel) }},
    wirePlainTextModel: {{ json_encode($wirePlainTextModel) }},
    hasInlineToolbar: {{ !empty($inlineToolbar) ? 'true' : 'false' }},
    placeholder: {{ json_encode($placeholder) }}
})"
     wire:ignore
     {{ $attributes->merge(['class' => $disableStyles ? 'styles-disabled' : '']) }}>
    <div x-ref="editorContainer"></div>

    @if (!empty($inlineToolbar))
        <div x-ref="inlineToolbar"
             class="absolute hidden">
            {{ $inlineToolbar }}
        </div>
    @endif
</div>
