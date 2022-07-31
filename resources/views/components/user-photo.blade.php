@props(['user'])

<img
  {{ $attributes->merge([
      'class' => 'rounded-full object-cover border-2 border-brand-clay-500',
      'src' => user($user)->profile_photo_url,
      'alt' => user($user)->name,
  ]) }} />
