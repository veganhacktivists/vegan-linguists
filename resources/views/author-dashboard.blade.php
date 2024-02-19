<x-app-layout>
  <x-slot name="pageTitle">{{ __('Dashboard') }}</x-slot>

  <x-page-container class="mt-4">
    <h2 class="mb-4 px-4 text-center text-2xl font-bold sm:px-0 sm:text-left">
      @if ($filter === 'complete')
        {{ __('Completed Translations') }}
      @elseif ($filter === 'incomplete')
        {{ __('Incomplete Translation Requests') }}
      @else
        {{ __('All Translation Requests') }}
      @endif
    </h2>

    @if ($sources->count() > 0)
      <x-stacked-list class="rounded-md">
        @foreach ($sources as $source)
          <x-dashboard.source-row :source="$source" :href="route('source', [$source->id, $source->slug])" />
        @endforeach
      </x-stacked-list>
    @elseif ($filter === 'complete')
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('You have no completed translations')">
        {{ __('Try coming back later to check the status of your translations') }}
      </x-empty-state>
    @elseif ($filter === 'incomplete')
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('You have no incomplete translations')">
        {{ __('Want to see something here?') }}

        <x-slot name="action">
          <x-button element="a" href="{{ route('request-translation') }}">
            {{ __('Request a translation') }}
          </x-button>
        </x-slot>
      </x-empty-state>
    @else
      <x-empty-state class="rounded-md bg-white p-8 shadow" icon="o-language" :title="__('You haven\'t requested any translations yet')">
        {{ __('Get started by requesting a translation') }}

        <x-slot name="action">
          <x-button element="a" href="{{ route('request-translation') }}">
            {{ __('Request a translation') }}
          </x-button>
        </x-slot>
      </x-empty-state>
    @endif
  </x-page-container>
</x-app-layout>
