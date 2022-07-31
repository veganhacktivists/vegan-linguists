@props(['progress' => 0])

@php
$ringColor = (function () use ($progress) {
    if ($progress <= 33) {
        return 'ring-brand-beige-300';
    }
    if ($progress <= 66) {
        return 'ring-brand-green-400';
    }
    return 'ring-brand-green-600';
})();

$color = str_replace('ring-', '', $ringColor);

$gradient = <<<CSS
background: conic-gradient(var(--color-{$color}) {$progress}%, white {$progress}%);
CSS;
@endphp

<div {{ $attributes->merge(['class' => "border-2 border-white ring $ringColor rounded-full", 'style' => $gradient]) }}>
</div>
