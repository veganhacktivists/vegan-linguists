@props(['content' => '', 'isReadOnly' => false])

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
    x-data="richTextEditor({{ $isReadOnly ? 'true' : 'false' }})"
    {{ $attributes }}
>
    <div x-ref="editorContent" class="hidden">{!! $content !!}</div>
    <div x-ref="editorContainer"></div>
</div>