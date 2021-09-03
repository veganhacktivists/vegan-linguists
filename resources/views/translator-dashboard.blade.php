<x-app-layout>
    <x-slot name="sidebar">
        <x-sidebar-link href="{{ route('queue', \Request::except('filter')) }}" :active="empty($filter)" icon="o-pencil">
            {{ __('Claimed') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('queue', ['filter' => 'unclaimed'] + \Request::all()) }}" :active="$filter === 'unclaimed'" icon="o-search">
            {{ __('Unclaimed') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('queue', ['filter' => 'complete'] + \Request::all()) }}" :active="$filter === 'complete'" icon="o-check">
            {{ __('Complete') }}
        </x-sidebar-link>
    </x-slot>

    <x-slot name="picker">
        <x-navbar-picker title="{{ __('Filter by Status') }}" x-data="" @change="window.location = $el.value">
            <option value="{{ route('queue', \Request::except('filter')) }}" {{ empty($filter) ? 'selected' : '' }}>
            {{ __('Claimed') }}
            </option>

            <option value="{{ route('queue', ['filter' => 'unclaimed'] + \Request::all()) }}" {{ $filter === 'unclaimed' ? 'selected' : '' }}>
            {{ __('Unclaimed') }}
            </option>

            <option value="{{ route('queue', ['filter' => 'complete'] + \Request::all()) }}" {{ $filter === 'complete' ? 'selected' : '' }}>
            {{ __('Complete') }}
            </option>

        </x-navbar-picker>
    </x-slot>

    <div x-data="{ source: '{{ $sourceLanguageCode }}', target: '{{ $targetLanguageCode }}', url: new URL(window.location) }"
         class="flex w-full ml-auto max-w-2xl p-4 items-center gap-4">
        <x-jet-select
            x-model="source"
            class="w-full" @change="url.searchParams.set('source', source); window.location = url">
            <x-jet-option value="">
                {{ __('All') }}
            </x-jet-option>
            @foreach ($languages as $language)
                <x-jet-option
                    :value="$language->code"
                    :selected="$language->code === $sourceLanguageCode"
                    >
                    {{ $language->native_name }}
                </x-jet-option>
            @endforeach
        </x-jet-select>

        <div>
            <x-heroicon-o-arrow-circle-right class="h-6 w-6" />
        </div>

        <x-jet-select
            x-model="target"
            class="w-full"
            @change="url.searchParams.set('target', target); window.location = url">
            <x-jet-option value="">
                {{ __('All') }}
            </x-jet-option>
            @foreach ($languages as $language)
                <x-jet-option
                    :value="$language->code"
                    :selected="$language->code === $targetLanguageCode">
                    {{ $language->native_name }}
                </x-jet-option>
            @endforeach
        </x-jet-select>
    </div>

    <x-stacked-list class="sm:mx-4 sm:rounded-md">
        @forelse ($translationRequests as $translationRequest)
            <x-dashboard.translation-request-row
                :translationRequest="$translationRequest"
                :href="route('translate', [$translationRequest->id, $translationRequest->source->slug])" />
        @empty
            <li class="p-4">
                {{ __('There are no unclaimed translation requests for the languages you speak. Try coming back another time!') }}
            </li>
        @endforelse
    </x-stacked-list>
</x-app-layout>
