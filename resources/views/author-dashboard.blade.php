<x-app-layout>
    <x-slot name="pageTitle">{{ __('Dashboard') }}</x-slot>

    <x-slot name="picker">
        <x-navbar-picker title="{{ __('Filter by Status') }}" x-data="" @change="window.Turbolinks.visit($el.value)">
            <option value="{{ route('home') }}" {{ empty($filter) ? 'selected' : '' }}>
                {{ __('All') }}
            </option>

            <option value="{{ route('home', ['filter' => 'complete']) }}"
                {{ $filter === 'complete' ? 'selected' : '' }}>
                {{ __('Complete') }}
            </option>

            <option value="{{ route('home', ['filter' => 'incomplete']) }}"
                {{ $filter === 'incomplete' ? 'selected' : '' }}>
                {{ __('Incomplete') }}
            </option>
        </x-navbar-picker>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-4">
            <h2 class="text-2xl font-bold mb-4 text-center sm:text-left">
                @if ($filter === 'complete')
                    {{ __('Completed Translations') }}
                @elseif ($filter === 'incomplete')
                    {{ __('Incomplete Translation Requests') }}
                @else
                    {{ __('All Translation Requests') }}
                @endif
            </h2>

            @if ($sources->count() > 0)
                <x-stacked-list class="sm:rounded-md">
                    @foreach ($sources as $source)
                        <x-dashboard.source-row :source="$source"
                            :href="route('source', [$source->id, $source->slug])" />
                    @endforeach
                </x-stacked-list>
            @elseif ($filter === 'complete')
                <x-empty-state class="bg-white shadow rounded p-8" icon="o-translate"
                    :title="__('You have no completed translations')">
                    {{ __('Try coming back later to check the status of your translations') }}
                </x-empty-state>
            @elseif ($filter === 'incomplete')
                <x-empty-state class="bg-white shadow rounded p-8" icon="o-translate"
                    :title="__('You have no incomplete translations')">
                    {{ __('Want to see something here?') }}

                    <x-slot name="action">
                        <x-jet-button element="a" href="{{ route('request-translation') }}">
                            {{ __('Request a translation') }}
                        </x-jet-button>
                    </x-slot>
                </x-empty-state>
            @else
                <x-empty-state class="bg-white shadow rounded p-8" icon="o-translate"
                    :title="__('You haven\'t requested any translations yet')">
                    {{ __('Get started by requesting a translation') }}

                    <x-slot name="action">
                        <x-jet-button element="a" href="{{ route('request-translation') }}">
                            {{ __('Request a translation') }}
                        </x-jet-button>
                    </x-slot>
                </x-empty-state>
            @endif
        </div>
    </div>
</x-app-layout>
