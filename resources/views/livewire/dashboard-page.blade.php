<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <x-heading-with-tabs title="{{ __('Translation requests') }}">
                        <x-heading-with-tabs-link
                            href="#"
                            wire:click.prevent="changeFilter('all')"
                            :isActive="$filter === 'all'"
                        >
                            {{ __('All') }}
                        </x-heading-with-tabs-link>
                        <x-heading-with-tabs-link
                            href="#"
                            wire:click.prevent="changeFilter('complete')"
                            :isActive="$filter === 'complete'"
                        >
                            {{ __('Complete') }}
                        </x-heading-with-tabs-link>
                        <x-heading-with-tabs-link
                            href="#"
                            wire:click.prevent="changeFilter('incomplete')"
                            :isActive="$filter === 'incomplete'"
                        >
                            {{ __('Incomplete') }}
                        </x-heading-with-tabs-link>
                    </x-heading-with-tabs>
                </div>

                <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                    <ul class="space-y-3">
                        @foreach ($sources as $source)
                            <x-dashboard.source-row :source="$source" />
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
