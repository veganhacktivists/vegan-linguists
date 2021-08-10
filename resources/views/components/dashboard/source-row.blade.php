<li {{ $attributes->merge([
    'x-data' => '{ collapsed: true }',
]) }}>
    <div class="bg-gray-50 shadow flex gap-2 rounded-md px-6 py-4">
        <div class="truncate flex-1">
            {{ $source->title }}
        </div>

        <div class="{{ $progressClass }} inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
            {{ $numCompleteTranslationRequests }} / {{ $totalTranslationRequests }}
        </div>

        <button @click="collapsed = !collapsed">
            <x-heroicon-o-chevron-down class="h-6 w-6" />
        </button>
    </div>

    <div class="flex flex-col gap-2 mt-2 hidden" x-bind:class="{ hidden: collapsed }">
        @foreach ($source->translationRequests as $translationRequest)
            <x-dashboard.translation-request-row class="ml-4 sm:ml-8" :translationRequest="$translationRequest" />
        @endforeach
    </div>
</li>
