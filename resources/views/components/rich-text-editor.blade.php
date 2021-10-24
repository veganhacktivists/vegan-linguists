@props(['content' => '{}', 'isReadOnly' => false, 'disableStyles' => false, 'autoFocus' => false, 'wireContentModel' => null, 'wirePlainTextModel' => null])

@push('scripts')
    {{-- This prevents the editor breaking due to Livewire/Turbolinks issues --}}
    <meta name="turbolinks-visit-control"
          content="reload">
@endpush

<div x-data="richTextEditor({
    readonly: {{ $isReadOnly ? 'true' : 'false' }},
    autofocus: {{ $autoFocus ? ' true' : 'false' }},
    content: {{ $content }},
    wireContentModel: {{ json_encode($wireContentModel) }},
    wirePlainTextModel: {{ json_encode($wirePlainTextModel) }},
})"
     wire:ignore
     {{ $attributes->merge(['class' => $disableStyles ? 'styles-disabled' : '']) }}>
    <div x-ref="editorContainer"></div>
</div>
