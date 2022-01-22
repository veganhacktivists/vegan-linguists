@props(['element' => 'button'])

<{{ $element }}
                     {{ $attributes->merge([
                         'class' => 'inline-flex px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-brand-blue-300 focus:ring focus:ring-brand-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition',
                     ]) }}>
    {{ $slot }}
    </{{ $element }}>
