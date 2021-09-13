@props(['user'])

<img {{ $attributes->merge([
    'class' => 'rounded-full object-cover',
    'src' => user($user)->profile_photo_url,
    'alt' => user($user)->name,
]) }} />
