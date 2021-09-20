@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
       {!! $attributes->merge(['class' => 'appearance-none block w-full px-3 py-2 border border-brandBrown-300 rounded-md shadow-sm placeholder-brandBrown-400 text-brandBrown-900 focus:outline-none focus:ring-brandBlue-500 focus:border-brandBlue-500 sm:text-sm']) !!}>
