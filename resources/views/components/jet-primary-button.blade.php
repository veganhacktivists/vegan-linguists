@props(['element' => 'button'])

<{{ $element }}
    {{ $attributes->merge([
    'class' => 'inline-flex px-4 py-2 border border-transparent rounded-md shadow-sm bg-brandGreen-400 hover:bg-brandGreen-500 text-white font-bold active:bg-brandGreen-600',
]) }}>
    {{ $slot }}
</{{ $element }}>
