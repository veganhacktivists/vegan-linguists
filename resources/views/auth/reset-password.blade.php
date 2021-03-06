<x-guest-layout>
  <x-jet-authentication-card>
    <x-slot name="logo">
      <x-icon-logo-with-text class="w-56 sm:w-80" />
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="block">
        <x-jet-label for="email" value="{{ __('Email') }}" />
        <x-jet-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email', $request->email)" required
          autofocus />
      </div>

      <div class="mt-4">
        <x-jet-label for="password" value="{{ __('Password') }}" />
        <x-password-input id="password" class="mt-1 block" name="password" required autocomplete="new-password" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <x-jet-button type="submit">
          {{ __('Reset password') }}
        </x-jet-button>
      </div>
    </form>
  </x-jet-authentication-card>
</x-guest-layout>
