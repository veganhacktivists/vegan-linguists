@props(['user'])

<img {{ $attributes->merge([
    'class' => 'rounded-full object-cover',
    'src' => $user->profile_photo_url,
    'alt' => $user->name,
]) }} />
