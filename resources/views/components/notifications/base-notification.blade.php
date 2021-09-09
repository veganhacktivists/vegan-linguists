<div class="flex space-x-3">
    <x-user-photo class="h-6 w-6 mt-1" :user="$user" />
    <div class="flex-1 space-y-1">
        <div class="flex items-center justify-between">
            <h3 class="font-medium">{{ $user->name }}</h3>
            <p class="text-gray-500">
                {{ $dateDiff }}
            </p>
        </div>
        <p class="text-gray-900">
            {!! $description !!}
        </p>

        {{ $slot }}
    </div>
</div>
