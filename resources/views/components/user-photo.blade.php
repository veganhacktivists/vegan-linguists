@props(['user'])

<img
     {{ $attributes->merge([
    'class' => 'rounded-full object-cover ring-2 ring-brandClay-500',
    'src' => user($user)->profile_photo_url,
    'alt' => user($user)->name,
]) }} />
