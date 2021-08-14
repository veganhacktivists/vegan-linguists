@props(['content' => '""', 'isReadOnly' => false])

@push('styles')
    @once
        <link rel="stylesheet" type="text/css" href="{{ mix('css/quill.snow.css') }}" />
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ mix('js/rich-text-editor.js') }}"></script>
    @endonce
@endpush

<div {{ $attributes->merge([
    'x-data' => "richTextEditor($content, $isReadOnly)",
    'class' => 'cursor-text flex flex-col h-full',
    'x-on:click' => 'editor.focus()',
]) }}>
    <div x-ref="editorContainer"></div>
</div>
