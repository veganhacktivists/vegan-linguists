<div class="flex space-x-3">
    @if (!empty($user))
        <x-user-photo class="h-6 w-6 mt-1"
                      :user="$user" />

        <div class="flex-1 space-y-1">
            <div class="flex items-center justify-between">
                <h3>{{ $user->name }}</h3>
                <p class="text-brandBrown-500 whitespace-nowrap pl-2">
                    {{ $dateDiff }}
                </p>
            </div>
            <p class="text-brandBrown-900 break-all">
                {!! $description !!}
            </p>

            <div class="break-all">
                {{ $slot }}
            </div>
        </div>
    @elseif (isset($icon))
        <div class="flex-1 space-y-1">
            <div class="flex items-start justify-between break-all">
                <div class="w-full">
                    {{ $slot }}
                </div>

                <p class="text-brandBrown-500 whitespace-nowrap pl-2">
                    {{ $dateDiff }}
                </p>
            </div>
        </div>
    @endif
</div>
