@props(['isActive'])

@php
    $class = $isActive
           ? 'border-indigo-500 text-indigo-600'
           : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';

    $defaultAttributes = [
        'class' => "whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm $class"
    ];

    if ($isActive) {
        $defaultAttributes['aria-current'] = 'page';
    }
@endphp


<a {{ $attributes->merge($defaultAttributes) }}>
    {{ $slot }}
</a>
