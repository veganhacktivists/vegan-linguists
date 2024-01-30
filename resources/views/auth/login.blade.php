<x-guest-layout>
  <div class="bg-noise flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 xl:flex-none xl:px-24">
      <div class="mx-auto w-full max-w-sm xl:w-96">
        <div>
          <x-icon-logo-abbreviated-transparent class="h-12 w-auto" />
          <h2 class="mt-6 text-3xl font-extrabold">
            {{ __('Log in to your account') }}
          </h2>
          <p class="mt-2">
            {{ __("Don't have an account yet?") }}
            <a href="{{ route('register') }}" class="font-bold text-brand-green-500 hover:text-brand-green-600">
              {{ __('Sign up') }}
            </a>
          </p>
        </div>

        <div class="mt-8">
          <x-validation-errors class="mb-4" />

          @if (session('status'))
            <x-alert type="success" :title="__('Success')" icon="s-check-circle">
              {{ session('status') }}
            </x-alert>
          @endif

          <form method="POST" class="space-y-6" action="{{ route('login') }}">
            @csrf
            <div>
              <x-label for="email" value="{{ __('Email address') }}" />

              <div class="mt-1">
                <x-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')"
                  required autofocus />
              </div>
            </div>

            <div>
              <x-label for="password" value="{{ __('Password') }}" />
              <div class="mt-1">
                <x-password-input id="password" class="mt-1 block" name="password" required
                  autocomplete="current-password" />
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <label for="remember_me" class="flex items-center">
                  <x-checkbox id="remember_me" name="remember" checked />
                  <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>
              </div>

              <div class="text-sm">
                <a href="{{ route('password.request') }}"
                  class="font-bold text-brand-green-500 hover:text-brand-green-600">
                  {{ __('Forgot your password?') }}
                </a>
              </div>
            </div>

            <div>
              <x-button type="submit" class="w-full justify-center">
                {{ __('Log in') }}
              </x-button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 xl:block">
      <img class="absolute inset-0 h-full w-full object-contain p-20" src="/img/animals-talking.png" alt="">
    </div>
  </div>
</x-guest-layout>
