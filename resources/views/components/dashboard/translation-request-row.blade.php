<div {{ $attributes->merge([
    'class' => "bg-gray-50 bg-opacity-100 shadow flex items-center gap-2 rounded-md px-6 py-4",
]) }}>
    <div class="truncate flex-1">
        @if ($isComplete)
            <a
                href="{{ route('translation', [
                    $source->id,
                    $translationRequest->language->id
                ]) }}"
                class="group flex items-center gap-1"
            >
                <span class="sm:hidden">
                    {{ strtoupper($translationRequest->language->code) }}
                </span>
                <span class="hidden sm:block">
                    {{ $translationRequest->language->fullName }}
                </span>
                <x-heroicon-o-arrow-sm-right
                    class="h-6 w-6 hidden sm:block transform transition-transform group-hover:translate-x-1" />
            </a>
        @else
            <div class="group flex items-center gap-1">
                <span class="sm:hidden">
                    {{ strtoupper($translationRequest->language->code) }}
                </span>
                <span class="hidden sm:block">
                    {{ $translationRequest->language->fullName }}
                </span>
            </div>
        @endif
    </div>

    <div class="{{ $statusClass }} inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
        {{ $statusText }}
    </div>
</div>
