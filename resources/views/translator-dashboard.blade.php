@php
    $claimedRoute = route('queue', \Request::except('filter'));
    $unclaimedRoute = route('queue', ['filter' => 'unclaimed'] + \Request::all());
    $completedRoute = route('queue', ['filter' => 'complete'] + \Request::all());
@endphp

<x-app-layout>
    <x-slot name="sidebar">
        <x-sidebar-link href="{{ $claimedRoute }}" :active="empty($filter)" icon="o-pencil">
            {{ __('Claimed') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ $unclaimedRoute }}" :active="$filter === 'unclaimed'" icon="o-search">
            {{ __('Unclaimed') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ $completedRoute }}" :active="$filter === 'complete'" icon="o-check">
            {{ __('Completed') }}
        </x-sidebar-link>
    </x-slot>

    <x-slot name="picker">
        <x-navbar-picker title="{{ __('Filter by Status') }}" x-data="" @change="window.location = $el.value">
            <option value="{{ $claimedRoute }}" {{ empty($filter) ? 'selected' : '' }}>
            {{ __('Claimed') }}
            </option>

            <option value="{{ $unclaimedRoute }}" {{ $filter === 'unclaimed' ? 'selected' : '' }}>
            {{ __('Unclaimed') }}
            </option>

            <option value="{{ $completedRoute }}" {{ $filter === 'complete' ? 'selected' : '' }}>
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

    <div class="sm:mx-4">
        @if ($translationRequests->count() > 0)
            <x-stacked-list class="sm:rounded-md">
                @foreach ($translationRequests as $translationRequest)
                    <x-dashboard.translation-request-row
                        :translationRequest="$translationRequest"
                        :href="route('translate', [$translationRequest->id, $translationRequest->source->slug])" />
                    @endforeach
            </x-stacked-list>
        @elseif ($filter === 'unclaimed')
            <x-empty-state class="bg-white shadow rounded p-8"
                           icon="o-translate"
                           :title="__('No translation requests found')">
                @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                    {{ __('Try selecting different languages to broaden your search.') }}
                @else
                    {{ __('Try coming back another time!') }}
                @endif
            </x-empty-state>
        @elseif ($filter === 'complete')
            <x-empty-state class="bg-white shadow rounded p-8"
                           icon="o-translate"
                           :title="__('No translations found')">
                @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                    {{ __('Try selecting different languages to broaden your search.') }}
                @else
                    {{ __('Want to see something here?') }}
                @endif

                <x-slot name="action">
                    <x-jet-button element="a" href="{{ $unclaimedRoute }}">
                        {{ __('Find content to translate') }}
                    </x-jet-button>
                </x-slot>
            </x-empty-state>
        @else
            <x-empty-state class="bg-white shadow rounded p-8"
                           icon="o-translate"
                           :title="__('No claimed translation requests')">

                @if (!empty($sourceLanguageCode) || !empty($targetLanguageCode))
                    {{ __('Try selecting different languages to broaden your search.') }}
                @else
                    {{ __('Want to see something here?') }}
                @endif

                <x-slot name="action">
                    <x-jet-button element="a" href="{{ $unclaimedRoute }}">
                        {{ __('Find content to translate') }}
                    </x-jet-button>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
</x-app-layout>
