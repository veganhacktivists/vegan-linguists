<x-guest-layout>
  <div class="bg-noise flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 xl:flex-none xl:px-24">
      <div class="mx-auto w-full max-w-sm xl:w-96">
        <div>
          <x-icon-logo-abbreviated-transparent class="h-12 w-auto" />
          <h2 class="mt-6 text-3xl font-extrabold">
            {{ __('Sign Up') }}
          </h2>
          <p class="mt-2 text-sm">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="font-bold text-brand-green-500 hover:text-brand-green-600">
              {{ __('Log in') }}
            </a>
          </p>
        </div>

        <div class="mt-8">
          <x-validation-errors class="mb-4" />

          <form method="POST" class="space-y-6" action="{{ route('register') }}">
            @csrf
            <div>
              <x-label for="name" value="{{ __('Name') }}" />
              <div class="mt-1">
                <x-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')"
                  required autofocus autocomplete="name" />
              </div>
            </div>
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

            <div>
              <x-label for="newsletter" id="newsletter-description">
                <div class="flex items-center">
                  <x-checkbox id="newsletter" aria-describedby="newsletter-description" name="newsletter" checked />

                  <div class="ml-2">
                    {{ __('Keep me updated with news related to Vegan Linguists') }}
                  </div>
                </div>
              </x-label>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
              <div>
                <x-label for="terms">
                  <div class="flex items-center">
                    <x-checkbox name="terms" id="terms" />

                    <div class="ml-2">
                      {!! __('I agree to the :terms_of_service and :privacy_policy', [
                          'terms_of_service' =>
                              '<a target="_blank" href="' .
                              route('terms.show') .
                              '" class="underline text-sm text-brand-brown-700 hover:text-brand-brown-900">' .
                              __('Terms of Service') .
                              '</a>',
                          'privacy_policy' =>
                              '<a target="_blank" href="' .
                              route('policy.show') .
                              '" class="underline text-sm text-brand-brown-700 hover:text-brand-brown-900">' .
                              __('Privacy Policy') .
                              '</a>',
                      ]) !!}
                    </div>
                  </div>
                </x-label>
              </div>
            @endif

            <div>
              <x-button type="submit" class="w-full justify-center">
                {{ __('Sign up') }}
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
