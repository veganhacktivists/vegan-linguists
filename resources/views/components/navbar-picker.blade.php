@props(['title'])

<label for="navbar-picker" class="sr-only">{{ $title }}</label>

<select {{ $attributes->merge([
    'id' => 'navbar-picker',
    'class' => 'rounded-md border-0 bg-none pl-3 pr-8 text-base font-medium text-gray-900 focus:ring-2 focus:ring-indigo-600',
]) }}>
    {{ $slot }}
</select>

<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center justify-center pr-2">
    <x-heroicon-s-chevron-down class="h-5 w-5 text-gray-500" />
</div>
