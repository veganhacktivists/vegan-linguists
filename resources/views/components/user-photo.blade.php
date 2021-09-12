@props(['user' => App\Models\User::deletedUser()])

<img {{ $attributes->merge([
    'class' => 'rounded-full object-cover',
    'src' => $user->profile_photo_url,
    'alt' => $user->name,
]) }} />
