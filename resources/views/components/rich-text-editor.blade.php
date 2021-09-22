@push('scripts')
    {{-- This prevents the editor breaking due to Livewire/Turbolinks issues --}}
    <meta name="turbolinks-visit-control"
          content="reload">
@endpush

@props(['content' => '', 'isReadOnly' => false, 'disableStyles' => false, 'autoFocus' => false])

<div x-data="richTextEditor({{ $isReadOnly ? 'true' : 'false' }}, {{ $autoFocus ? ' true' : 'false' }})"
     {{ $attributes->merge([
    'class' => $disableStyles ? 'styles-disabled' : '',
]) }}>
    <div x-ref="editorContent"
         class="hidden">{!! $content !!}</div>
    <div x-ref="editorContainer"></div>
</div>
