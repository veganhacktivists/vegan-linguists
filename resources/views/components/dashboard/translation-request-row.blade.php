<div {{ $attributes->merge([
    'class' => "bg-gray-50 bg-opacity-100 shadow flex gap-2 rounded-md px-6 py-4",
]) }}>
    <div class="truncate flex-1 sm:hidden">
        {{ strtoupper($translationRequest->language->code) }}
    </div>

    <div class="truncate flex-1 hidden sm:block">
        {{ $translationRequest->language->name }} ({{ $translationRequest->language->native_name }})
    </div>

    <div class="{{ $statusClass }} inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
        {{ $statusText }}
    </div>
</div>
