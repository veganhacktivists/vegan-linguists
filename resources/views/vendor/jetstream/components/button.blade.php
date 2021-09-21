@props(['element' => 'button'])

<{{ $element }}
                     {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-brandBrown-800 border border-transparent rounded-md font-semibold text-xs text-brandBeige-100 uppercase tracking-widest hover:bg-brandBrown-700 active:bg-brandBrown-900 focus:outline-none focus:border-brandBrown-900 focus:ring focus:ring-brandBrown-300 disabled:opacity-50 disabled:hover:bg-brandBrown-800 transition']) }}>
    {{ $slot }}
    </{{ $element }}>
