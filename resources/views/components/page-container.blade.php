<div {{ $attributes->merge([
    'class' => 'px-8 pb-8',
]) }}>
    <div class="max-w-7xl mx-auto">
        {{ $slot }}
    </div>
</div>
