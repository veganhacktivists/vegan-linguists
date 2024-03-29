<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-icon-logo-with-text class="w-56 sm:w-80" />
    </x-slot>

    <div class="mb-4 text-sm text-brand-brown-600">
      {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="mb-4 text-sm font-medium text-brand-green-500">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
      </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
          <x-button type="submit">
            {{ __('Resend verification email') }}
          </x-button>
        </div>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="text-sm text-brand-brown-600 underline hover:text-brand-brown-900">
          {{ __('Log Out') }}
        </button>
      </form>
    </div>
  </x-authentication-card>
</x-guest-layout>
