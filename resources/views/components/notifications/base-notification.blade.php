<div class="flex space-x-3">
    @if (!empty($user))
        <x-user-photo class="h-6 w-6 mt-1"
                      :user="$user" />

        <div class="flex-1 space-y-1">
            <div class="flex items-center justify-between">
                <h3>{{ $user->name }}</h3>
                <p class="text-brand-brown-500 whitespace-nowrap pl-2">
                    {{ $dateDiff }}
                </p>
            </div>
            <p class="text-brand-brown-900 break-words">
                {!! $description !!}
            </p>

            <div class="break-words">
                {{ $slot }}
            </div>
        </div>
    @elseif (isset($icon))
        <div class="flex-1 space-y-1">
            <div class="flex items-start justify-between break-words">
                <div class="w-full">
                    {{ $slot }}
                </div>

                <p class="text-brand-brown-500 whitespace-nowrap pl-2">
                    {{ $dateDiff }}
                </p>
            </div>
        </div>
    @endif
</div>
