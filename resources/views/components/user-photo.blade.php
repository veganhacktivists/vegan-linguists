@props(['user'])

<img {{ $attributes->merge([
    'class' => 'rounde-full object-cover',
    'src' => user($user)->profile_photo_url,
    'alt' => user($user)->name,
]) }} />
