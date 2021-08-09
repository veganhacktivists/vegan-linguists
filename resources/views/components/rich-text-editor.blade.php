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
    'x-data' => '{ editor: null }',
    'class' => 'cursor-text flex flex-col h-full',
    'x-on:click' => 'editor.focus()',
]) }}>
    <div
        x-init="editor = new RichTextEditor($el).on('text-change', () => $dispatch('change', { content: editor.getContent(), plainText: editor.getPlainText() }))"
        ></div>
</div>
