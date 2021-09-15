<x-guest-layout>
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <img class="h-12 w-auto"
                         src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                         alt="Workflow">
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        {{ __('Sign Up') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}"
                           class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ __('Log in') }}
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <x-jet-validation-errors class="mb-4" />

                    <form method="POST"
                          class="space-y-6"
                          action="{{ route('register') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name"
                                         value="{{ __('Name') }}" />
                            <div class="mt-1">
                                <x-jet-input id="name"
                                             class="block mt-1 w-full"
                                             type="text"
                                             name="name"
                                             :value="old('name')"
                                             required
                                             autofocus
                                             autocomplete="name" />
                            </div>
                        </div>
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

                        <div>
                            <x-jet-label for="languages"
                                         value="{{ __('What language(s) do you speak?') }}" />
                            <div class="mt-1">
                                <x-language-picker id="languages"
                                                   class="block mt-1"
                                                   name="languages" />
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div>
                                <x-jet-label for="terms">
                                    <div class="flex items-center">
                                        <x-jet-checkbox name="terms"
                                                        id="terms" />

                                        <div class="ml-2">
                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                                        </div>
                                    </div>
                                </x-jet-label>
                            </div>
                        @endif

                        <div>
                            <x-jet-button type="submit"
                                          class="w-full justify-center">
                                {{ __('Sign Up') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover"
                 src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
                 alt="">
        </div>
    </div>
</x-guest-layout>
