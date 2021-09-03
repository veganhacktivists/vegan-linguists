<x-app-layout>
    <x-slot name="sidebar">
        <x-sidebar-link href="{{ route('dashboard') }}" icon="o-collection" :active="empty($filter)">
            {{ __('All') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('dashboard', ['filter' => 'complete']) }}" :active="$filter === 'complete'" icon="o-check">
            {{ __('Complete') }}
        </x-sidebar-link>

        <x-sidebar-link href="{{ route('dashboard', ['filter' => 'incomplete']) }}" :active="$filter === 'incomplete'" icon="o-clock">
            {{ __('Incomplete') }}
        </x-sidebar-link>
    </x-slot>

    <x-slot name="picker">
        <x-navbar-picker title="{{ __('Filter by Status') }}" x-data="" @change="window.location = $el.value">
            <option value="{{ route('dashboard') }}" {{ empty($filter) ? 'selected' : '' }}>
                {{ __('All') }}
            </option>

            <option value="{{ route('dashboard', ['filter' => 'complete']) }}" {{ $filter === 'complete' ? 'selected' : '' }}>
                {{ __('Complete') }}
            </option>

            <option value="{{ route('dashboard', ['filter' => 'incomplete']) }}" {{ $filter === 'incomplete' ? 'selected' : '' }}>
                {{ __('Incomplete') }}
            </option>
        </x-navbar-picker>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-4">
            <x-stacked-list class="sm:rounded-md">
                @forelse ($sources as $source)
                    <x-dashboard.source-row :source="$source" :href="route('source', [$source->id, $source->slug])" />
                @empty
                    <p class="p-4">
                        {{ __("You haven't requested any translations yet.") }}
                        <a class="text-indigo-500 hover:text-indigo-700" href="{{ route('request-translation') }}">
                            {{ __('Request a translation.') }}
                        </a>
                    </p>
                @endforelse
            </x-stacked-list>
        </div>
    </div>
</x-app-layout>
