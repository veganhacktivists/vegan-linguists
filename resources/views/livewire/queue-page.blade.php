<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <x-heading-with-actions title="{{ __('Translation requests') }}">
                        <div class="md:w-3/4 ml-auto flex gap-2 items-center">
                            <x-jet-select
                                id="source-language"
                                wire:model="sourceLanguageFilter"
                                wire:change="refreshTranslationRequests"
                                class="w-full"
                            >
                                <x-jet-option value="-1">
                                    {{ __('All') }}
                                </x-jet-option>
                                @foreach ($languages as $language)
                                    <x-jet-option value="{{ $language->id }}">
                                        {{ strtoupper($language->code) }}
                                    </x-jet-option>
                                @endforeach
                            </x-jet-select>

                            <div>
                                <x-heroicon-o-arrow-circle-right class="h-6 w-6" />
                            </div>

                            <x-jet-select
                                id="source-language"
                                wire:model="targetLanguageFilter"
                                wire:change="refreshTranslationRequests"
                                class="w-full"
                            >
                                <x-jet-option value="-1">
                                    {{ __('All') }}
                                </x-jet-option>
                                @foreach ($languages as $language)
                                    <x-jet-option value="{{ $language->id }}">
                                        {{ strtoupper($language->code) }}
                                    </x-jet-option>
                                @endforeach
                            </x-jet-select>
                        </div>
                    </x-heading-with-actions>
                </div>

                <div class="px-4 pb-5 sm:px-6 sm:pb-6">
                    <ul class="space-y-3">
                        @foreach ($translationRequests as $translationRequest)
                            <li>
                                <div class="bg-gray-50 shadow flex items-center gap-2 rounded-md px-6 py-4">
                                    <div class="truncate flex-1">
                                        {{ $translationRequest->source->title }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <div>
                                            {{ strtoupper($translationRequest->source->language->code) }}
                                        </div>

                                        <x-heroicon-o-arrow-circle-right class="h-4 w-4" />

                                        <div>
                                            {{ strtoupper($translationRequest->language->code) }}
                                        </div>
                                    </div>
                                    <div>
                                        <img
                                            class="h-8 w-8 rounded-full object-cover"
                                            src="{{ $translationRequest->source->author->profile_photo_url }}"
                                            alt="{{ $translationRequest->source->author->name }}" />
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
