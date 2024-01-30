<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-icon-logo-with-text class="w-56 sm:w-80" />
    </x-slot>

    <div class="mb-4 text-sm text-brand-brown-600">
      {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf

      <div>
        <x-label for="password" value="{{ __('Password') }}" />
        <x-password-input id="password" class="mt-1 block" name="password" required autocomplete="current-password"
          autofocus />
      </div>

      <div class="mt-4 flex justify-end">
        <x-button class="ml-4" type="submit">
          {{ __('Confirm') }}
        </x-button>
      </div>
    </form>
  </x-authentication-card>
</x-guest-layout>
