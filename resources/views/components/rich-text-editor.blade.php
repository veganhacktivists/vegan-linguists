@props(['content' => '', 'isReadOnly' => false, 'disableStyles' => false, 'autoFocus' => false])

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

<div
    x-data="richTextEditor({{ $isReadOnly ? 'true' : 'false' }}, {{ $autoFocus ? ' true' : 'false' }})"
    {{ $attributes->merge([
        'class' => $disableStyles ? 'styles-disabled' : '',
    ]) }}
>
    <div x-ref="editorContent" class="hidden">{!! $content !!}</div>
    <div x-ref="editorContainer"></div>
</div>
