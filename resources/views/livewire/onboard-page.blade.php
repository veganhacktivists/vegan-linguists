@php
use App\Models\UserMode;
@endphp

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

<div class="pt-12 pb-6 relative">
    <form method="POST"
          class="absolute top-4 right-4"
          action="{{ route('logout') }}">
        @csrf

        <a href="{{ route('logout') }}"
           class="hover:underline"
           onclick="event.preventDefault(); this.closest('form').submit();">
            {{ __('Log Out') }}
        </a>
    </form>

    <form class="px-8 flex flex-col gap-12"
          x-data="{ userMode: null }"
          @submit.prevent="$wire.completeOnboarding(userMode)">

        <div class="text-center">
            <h1 class="text-4xl font-bold">
                {{ __('Welcome to the Vegan Linguists!') }}
            </h1>
            <p class="text-xl mt-4">
                {{ __("Let's get your account set up") }}
            </p>
        </div>

        <fieldset class="max-w-2xl w-full mx-auto">
            <legend class="text-xl my-4 text-center">
                {{ __('First things first. How will you be using the Vegan Linguists website?') }}
            </legend>
            <div class="bg-white rounded-md -space-y-px">
                <label class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none"
                       x-bind:class="{ 'bg-brandBlue-50 border-brandBlue-200 z-10': userMode === '{{ UserMode::TRANSLATOR }}', 'border-brandBrown-200': userMode !== '{{ UserMode::TRANSLATOR }}' }">
                    <input type="radio"
                           name="user-mode"
                           value="{{ UserMode::TRANSLATOR }}"
                           class="h-4 w-4 mt-0.5 cursor-pointer text-brandBlue-600 border-brandBrown-300 focus:ring-brandBlue-500"
                           aria-labelledby="user-mode-0-label"
                           required
                           wire:model="userMode"
                           @change="userMode = '{{ UserMode::TRANSLATOR }}'">
                    <div class="ml-3 flex flex-col">
                        <span id="user-mode-0-label"
                              class="block text-sm"
                              x-bind:class="{ 'text-brandBlue-900': userMode === '{{ UserMode::TRANSLATOR }}', 'text-brandBrown-900': userMode !== '{{ UserMode::TRANSLATOR }}' }">
                            {{ __('I want to translate content.') }}
                        </span>
                    </div>
                </label>

                <label class="relative border p-4 flex cursor-pointer focus:outline-none"
                       x-bind:class="{ 'bg-brandBlue-50 border-brandBlue-200 z-10': userMode === '{{ UserMode::AUTHOR }}', 'border-brandBrown-200': userMode !== '{{ UserMode::AUTHOR }}' }">
                    <input type="radio"
                           name="user-mode"
                           value="{{ UserMode::AUTHOR }}"
                           class="h-4 w-4 mt-0.5 cursor-pointer text-brandBlue-600 border-brandBrown-300 focus:ring-brandBlue-500"
                           aria-labelledby="user-mode-1-label"
                           wire:model="userMode"
                           @change="userMode = '{{ UserMode::AUTHOR }}'">
                    <div class="ml-3 flex flex-col">
                        <span id="user-mode-1-label"
                              class="block text-sm"
                              x-bind:class="{ 'text-brandBlue-900': userMode === '{{ UserMode::AUTHOR }}', 'text-brandBrown-900': userMode !== '{{ UserMode::AUTHOR }}' }">
                            {{ __('I want to submit content to be translated.') }}
                        </span>
                    </div>
                </label>

                <label class="rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer focus:outline-none"
                       x-bind:class="{ 'bg-brandBlue-50 border-brandBlue-200 z-10': userMode === 'both', 'border-brandBrown-200': userMode !== 'both' }">
                    <input type="radio"
                           name="user-mode"
                           value="both"
                           class="h-4 w-4 mt-0.5 cursor-pointer text-brandBlue-600 border-brandBrown-300 focus:ring-brandBlue-500"
                           aria-labelledby="user-mode-2-label"
                           wire:model="userMode"
                           @change="userMode = 'both'">
                    <div class="ml-3 flex flex-col">
                        <span id="user-mode-2-label"
                              class="block text-sm"
                              x-bind:class="{ 'text-brandBlue-900': userMode === 'both', 'text-brandBrown-900': userMode !== 'both' }">
                            {{ __('I want to do both.') }}
                        </span>
                    </div>
                </label>
            </div>
        </fieldset>

        <fieldset class="max-w-2xl w-full mx-auto hidden"
                  x-bind:class="{ hidden: userMode === null }">
            <legend class="text-xl my-4 text-center">
                <div x-show="userMode !== '{{ UserMode::AUTHOR }}'">
                    {{ __('Nice! Which languages can you read and write fluently?') }}
                </div>
                <div x-show="userMode === '{{ UserMode::AUTHOR }}'">
                    {{ __('Excellent. Which languages is your content written in?') }}
                </div>
            </legend>
            <x-language-picker class="w-full"
                               wire:model="languages" />
        </fieldset>

        <fieldset class="max-w-2xl w-full mx-auto hidden"
                  x-bind:class="{ hidden: !userMode || userMode === '{{ UserMode::TRANSLATOR }}' }">
            <legend class="text-xl my-4 text-center">
                {{ __('Which languages do you typically want your content to be translated to?') }}
            </legend>
            <x-language-picker class="w-full"
                               shouldDisplayTranslatedLanguage
                               wire:model="targetLanguages" />
        </fieldset>

        <x-jet-validation-errors class="max-w-2xl w-full mx-auto" />

        <x-jet-primary-button type="submit"
                              class="mx-auto">{{ __('Get started') }}</x-jet-primary-button>
    </form>
</div>
