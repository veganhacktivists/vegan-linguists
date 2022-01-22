<x-guest-layout>
    <div class="min-h-screen bg-noise flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 xl:flex-none xl:px-24">
            <div class="mx-auto w-full max-w-sm xl:w-96">
                <div>
                    <x-icon-logo-abbreviated-transparent class="h-12 w-auto" />
                    <h2 class="mt-6 text-3xl font-extrabold">
                        {{ __('Log in to your account') }}
                    </h2>
                    <p class="mt-2">
                        {{ __("Don't have an account yet?") }}
                        <a href="{{ route('register') }}"
                           class="text-brand-green-500 hover:text-brand-green-600 font-bold">
                            {{ __('Sign up') }}
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <x-alert type="success"
                                 :title="__('Success')"
                                 icon="s-check-circle">
                            {{ session('status') }}
                        </x-alert>
                    @endif

                    <form method="POST"
                          class="space-y-6"
                          action="{{ route('login') }}">
                        @csrf
                        <div>
                            <x-jet-label for="email"
                                         value="{{ __('Email address') }}" />

                            <div class="mt-1">
                                <x-jet-input id="email"
                                             class="block mt-1 w-full"
                                             type="email"
                                             name="email"
                                             :value="old('email')"
                                             required
                                             autofocus />
                            </div>
                        </div>

                        <div>
                            <x-jet-label for="password"
                                         value="{{ __('Password') }}" />
                            <div class="mt-1">
                                <x-password-input id="password"
                                                  class="block mt-1"
                                                  name="password"
                                                  required
                                                  autocomplete="current-password" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <label for="remember_me"
                                       class="flex items-center">
                                    <x-jet-checkbox id="remember_me"
                                                    name="remember"
                                                    checked />
                                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}"
                                   class="text-brand-green-500 hover:text-brand-green-600 font-bold">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        </div>

                        <div>
                            <x-jet-button type="submit"
                                          class="w-full justify-center">
                                {{ __('Log in') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="hidden xl:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full p-20 object-contain"
                 src="/img/animals-talking.png"
                 alt="">
        </div>
    </div>
</x-guest-layout>
