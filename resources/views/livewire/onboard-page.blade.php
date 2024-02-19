@php
use App\Models\UserMode;
@endphp

@push('styles')
  @livewireStyles
@endpush

@push('scripts')
  @livewireScripts
@endpush

<div class="relative pt-12 pb-6">
  <form method="POST" class="absolute top-4 right-4" action="{{ route('logout') }}">
    @csrf

    <a href="{{ route('logout') }}" class="hover:underline" x-data @click.prevent="$el.closest('form').submit();">
      {{ __('Log Out') }}
    </a>
  </form>

  <form class="flex flex-col gap-12 px-8" x-data="{ userMode: null }" @submit.prevent="$wire.completeOnboarding(userMode)">

    <div class="text-center">
      <h1 class="text-4xl font-bold">
        {{ __('Welcome to the Vegan Linguists!') }}
      </h1>
      <p class="mt-4 text-xl">
        {{ __("Let's get your account set up") }}
      </p>
    </div>

    <fieldset class="mx-auto w-full max-w-2xl">
      <legend class="my-4 text-center text-xl">
        {{ __('First things first. How will you be using the Vegan Linguists website?') }}
      </legend>
      <div class="-space-y-px rounded-md bg-white">
        <label class="relative flex cursor-pointer rounded-tl-md rounded-tr-md border p-4 focus:outline-none"
          x-bind:class="{ 'bg-brand-blue-50 border-brand-blue-200 z-10': userMode ===
              '{{ UserMode::TRANSLATOR }}', 'border-brand-brown-200': userMode !== '{{ UserMode::TRANSLATOR }}' }">
          <input type="radio" name="user-mode" value="{{ UserMode::TRANSLATOR }}"
            class="mt-0.5 h-4 w-4 cursor-pointer border-brand-brown-300 text-brand-blue-600 focus:ring-brand-blue-500"
            aria-labelledby="user-mode-0-label" required wire:model.live="userMode"
            @change="userMode = '{{ UserMode::TRANSLATOR }}'">
          <div class="ml-3 flex flex-col">
            <span id="user-mode-0-label" class="block text-sm"
              x-bind:class="{ 'text-brand-blue-900': userMode === '{{ UserMode::TRANSLATOR }}', 'text-brand-brown-900': userMode !==
                      '{{ UserMode::TRANSLATOR }}' }">
              {{ __('I want to translate content.') }}
            </span>
          </div>
        </label>

        <label class="relative flex cursor-pointer border p-4 focus:outline-none"
          x-bind:class="{ 'bg-brand-blue-50 border-brand-blue-200 z-10': userMode ===
              '{{ UserMode::AUTHOR }}', 'border-brand-brown-200': userMode !== '{{ UserMode::AUTHOR }}' }">
          <input type="radio" name="user-mode" value="{{ UserMode::AUTHOR }}"
            class="mt-0.5 h-4 w-4 cursor-pointer border-brand-brown-300 text-brand-blue-600 focus:ring-brand-blue-500"
            aria-labelledby="user-mode-1-label" wire:model.live="userMode" @change="userMode = '{{ UserMode::AUTHOR }}'">
          <div class="ml-3 flex flex-col">
            <span id="user-mode-1-label" class="block text-sm"
              x-bind:class="{ 'text-brand-blue-900': userMode === '{{ UserMode::AUTHOR }}', 'text-brand-brown-900': userMode !==
                      '{{ UserMode::AUTHOR }}' }">
              {{ __('I want to submit content to be translated.') }}
            </span>
          </div>
        </label>

        <label class="relative flex cursor-pointer rounded-bl-md rounded-br-md border p-4 focus:outline-none"
          x-bind:class="{ 'bg-brand-blue-50 border-brand-blue-200 z-10': userMode === 'both', 'border-brand-brown-200': userMode !==
                  'both' }">
          <input type="radio" name="user-mode" value="both"
            class="mt-0.5 h-4 w-4 cursor-pointer border-brand-brown-300 text-brand-blue-600 focus:ring-brand-blue-500"
            aria-labelledby="user-mode-2-label" wire:model.live="userMode" @change="userMode = 'both'">
          <div class="ml-3 flex flex-col">
            <span id="user-mode-2-label" class="block text-sm"
              x-bind:class="{ 'text-brand-blue-900': userMode === 'both', 'text-brand-brown-900': userMode !== 'both' }">
              {{ __('I want to do both.') }}
            </span>
          </div>
        </label>
      </div>
    </fieldset>

    <fieldset class="mx-auto hidden w-full max-w-2xl" x-bind:class="{ hidden: userMode === null }">
      <legend class="my-4 text-center text-xl">
        <div x-show="userMode !== '{{ UserMode::AUTHOR }}'">
          {{ __('Nice! Which languages can you read and write fluently?') }}
        </div>
        <div x-show="userMode === '{{ UserMode::AUTHOR }}'">
          {{ __('Excellent. Which languages is your content written in?') }}
        </div>
      </legend>
      <x-language-picker class="w-full" :defaultLanguages="$defaultLanguages" wire:model.live="languages" />
    </fieldset>

    <fieldset class="mx-auto hidden w-full max-w-2xl"
      x-bind:class="{ hidden: !userMode || userMode === '{{ UserMode::TRANSLATOR }}' }">
      <legend class="my-4 text-center text-xl">
        {{ __('Which languages do you typically want your content to be translated to?') }}
      </legend>
      <x-language-picker class="w-full" shouldDisplayTranslatedLanguage wire:model.live="targetLanguages" />
    </fieldset>

    <x-validation-errors class="mx-auto w-full max-w-2xl" />

    <x-primary-button type="submit" class="mx-auto">{{ __('Get started') }}</x-primary-button>
  </form>
</div>
