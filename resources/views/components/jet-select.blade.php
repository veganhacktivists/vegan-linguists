<select
        {{ $attributes->merge([
            'class' => 'pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-brand-blue-500 focus:border-brand-blue-500 sm:text-sm rounded-md',
        ]) }}>
    {{ $slot }}
</select>
