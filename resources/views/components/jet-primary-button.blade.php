@props(['element' => 'button'])

<{{ $element }}
                     {{ $attributes->merge([
                         'class' => 'inline-flex px-4 py-2 border border-transparent rounded-md shadow-sm bg-brand-green-400 hover:bg-brand-green-500 text-white font-bold active:bg-brand-green-600',
                     ]) }}>
    {{ $slot }}
    </{{ $element }}>
