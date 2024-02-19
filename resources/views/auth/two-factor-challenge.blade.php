<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-icon-logo-with-text class="w-56 sm:w-80" />
    </x-slot>

    <div x-data="{ recovery: false }">
      <div class="mb-4 text-sm text-brand-brown-600" x-show="! recovery">
        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
      </div>

      <div class="mb-4 text-sm text-brand-brown-600" x-show="recovery">
        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
      </div>

      <x-validation-errors class="mb-4" />

      <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="mt-4" x-show="! recovery">
          <x-label for="code" value="{{ __('Code') }}" />
          <x-input id="code" class="mt-1 block w-full" type="text" inputmode="numeric" name="code"
            autofocus x-ref="code" autocomplete="off" />
        </div>

        <div class="mt-4" x-show="recovery">
          <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
          <x-input id="recovery_code" class="mt-1 block w-full" type="text" name="recovery_code"
            x-ref="recovery_code" autocomplete="off" />
        </div>

        <div class="mt-4 flex items-center justify-end">
          <button type="button"
            class="cursor-pointer text-sm text-brand-brown-600 underline hover:text-brand-brown-900" x-show="! recovery"
            x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
            {{ __('Use a recovery code') }}
          </button>

          <button type="button"
            class="cursor-pointer text-sm text-brand-brown-600 underline hover:text-brand-brown-900" x-show="recovery"
            x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
            {{ __('Use an authentication code') }}
          </button>

          <x-button type="submit" class="ml-4">
            {{ __('Log in') }}
          </x-button>
        </div>
      </form>
    </div>
  </x-authentication-card>
</x-guest-layout>
