@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'appearance-none block w-full px-3 py-2 border border-brand-brown-300 rounded-md shadow-sm placeholder-brand-brown-400 text-brand-brown-900 focus:outline-none focus:ring-brand-blue-500 focus:border-brand-blue-500 sm:text-sm',
]) !!}>
