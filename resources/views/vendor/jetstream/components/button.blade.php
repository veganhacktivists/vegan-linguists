@props(['element' => 'button'])

<{{ $element }}
                     {{ $attributes->merge([
                         'class' => 'inline-flex px-4 py-2 bg-brand-brown-800 border border-transparent rounded-md font-bold text-xs text-brand-beige-100 hover:bg-brand-brown-700 active:bg-brand-brown-900 focus:outline-none focus:border-brand-brown-900 focus:ring focus:ring-brand-brown-300 disabled:opacity-50 disabled:hover:bg-brand-brown-800 transition',
                     ]) }}>
    {{ $slot }}
    </{{ $element }}>
