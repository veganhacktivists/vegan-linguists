@props(['content' => '', 'isReadOnly' => false, 'disableStyles' => false, 'autoFocus' => false])

<div x-data="richTextEditor({{ $isReadOnly ? 'true' : 'false' }}, {{ $autoFocus ? ' true' : 'false' }})"
    {{ $attributes->merge([
    'class' => $disableStyles ? 'styles-disabled' : '',
]) }}>
    <div x-ref="editorContent" class="hidden">{!! $content !!}</div>
    <div x-ref="editorContainer"></div>
</div>
