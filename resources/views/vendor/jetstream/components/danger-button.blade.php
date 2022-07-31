@props(['element' => 'button'])

<{{ $element }}
  {{ $attributes->merge([
      'class' =>
          'inline-flex justify-center px-4 py-2 bg-white border border-brand-clay-400 border-transparent rounded-md font-semibold text-xs text-brand-clay-600 active:text-white font-bold hover:text-white hover:bg-brand-clay-500 focus:outline-none focus:border-brand-clay-700 focus:ring focus:ring-brand-clay-200 active:bg-brand-clay-600 disabled:opacity-25 transition',
  ]) }}>
  {{ $slot }}
  </{{ $element }}>
