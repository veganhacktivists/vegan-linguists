<div class="bg-indigo-50 shadow relative">
    <div {{ $attributes->merge([
        'class' => 'max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 w-full',
    ]) }}>
        {{ $slot }}
    </div>
</div>
