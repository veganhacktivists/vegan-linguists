<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}">
</head>

<body class="bg-brandBeige-100 bg-opacity-60 text-brandBrown-900">
    <header>
        <div class="relative bg-brandBrown-900">
            <div
                 class="flex justify-between items-center max-w-7xl mx-auto px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="{{ route('home') }}">
                        <span class="sr-only">Vegan Linguists</span>
                        <x-icon-logo-text-only class="h-5 -mb-2 w-auto sm:h-8 sm:-mb-3" />
                    </a>
                </div>

                <div class=" flex items-center justify-end md:flex-1 lg:w-0">
                    <a href="{{ route('login') }}"
                       class="whitespace-nowrap text-base text-brandBeige-300 hover:text-brandBeige-100 font-bold">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex ml-4 sm:ml-8 whitespace-nowrap items-center justify-center bg-brandClay-500 hover:bg-brandClay-600 px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-bold text-white">
                        {{ __('Sign up') }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="landing-hero">
            <div class="absolute inset-x-0 bottom-0 h-1/2"></div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative px-4 py-16 sm:px-6 lg:px-8">
                    <x-icon-logo-with-text class="h-40 sm:h-64 mx-auto" />
                    <h1 class="text-center font-extrabold tracking-tight text-3xl mt-5">
                        {{ __('Have vegan content? Get it translated.') }}
                    </h1>
                    <p class="mt-6 max-w-lg mx-auto text-center text-xl sm:max-w-xl">
                        {{ __('Vegan Linguists is a free service run by vegans, for vegans. We want to translate content related to veganism to help build a more connected, more vegan world.') }}
                    </p>
                    <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                        <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-4">
                            <a href="{{ route('register') }}"
                               class="flex items-center justify-center px-3 py-2 border border-transparent text-base rounded-md shadow-sm bg-brandGreen-400 hover:bg-brandGreen-500 text-white font-bold">
                                {{ __('Get content translated') }}
                            </a>
                            <a href="{{ route('register') }}"
                               class="flex items-center justify-center px-3 py-2 border border-transparent text-base rounded-md shadow-sm text-white bg-brandClay-500 hover:bg-brandClay-600 font-bold">
                                {{ __('Translate content') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative pt-16 pb-32 overflow-hidden">
            <div aria-hidden="true"
                 class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
            <div class="relative">
                <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                        <div class="mt-6">
                            <h2 class="text-3xl font-extrabold tracking-tight">
                                {{ __('Reach a much wider audience') }}
                            </h2>
                            <p class="mt-4 text-lg">
                                {{ __("Every day, more and more people get connected to the internet. As a result, it's becoming increasingly more important to translate online content to reach more people. We want to break through language barriers and spread vegan content across the globe.") }}
                            </p>
                            <p class="mt-4 text-lg text-brandBrown-800">
                                {{ __("Our team of translators will translate your content for free. All you need to do is sign up and submit your content. We'll take care of the rest.") }}
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('register') }}"
                                   class="inline-flex px-4 py-2 border border-transparent text-base rounded-md shadow-sm bg-brandGreen-400 hover:bg-brandGreen-500 text-white font-bold">
                                    {{ __('Get started') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0">
                        <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                            <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                 src="https://tailwindui.com/img/component-images/inbox-app-screenshot-1.jpg"
                                 alt="{{ __('Content author interface') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-24">
                <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                        <div class="mt-6">
                            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                                {{ __('Translate for the animals') }}
                            </h2>
                            <p class="mt-4 text-lg text-brandBrown-800">
                                {{ __('If you speak more than one language, you can help the vegan movement from the comfort of your own home. Your activism will help make vegan content more accessible around the world.') }}
                            </p>
                            <p class="mt-4 text-lg text-brandBrown-800">
                                {{ __('We need your help to build bridges across languages and cultures. Register to find vegan content that needs to be translated to the languages you speak.') }}
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('register') }}"
                                   class="inline-flex px-4 py-2 border border-transparent text-base rounded-md shadow-sm bg-brandGreen-400 hover:bg-brandGreen-500 text-white font-bold">
                                    {{ __('Get started') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                        <div class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                            <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                                 src="https://tailwindui.com/img/component-images/inbox-app-screenshot-2.jpg"
                                 alt="Customer profile user interface">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative bg-brandBrown-900">
            <div class="hidden xl:block h-80 absolute inset-x-0 bottom-0 xl:top-0 xl:h-full">
                <div class="h-full w-full xl:grid xl:grid-cols-12">
                    <div class="h-full xl:relative xl:col-start-8 xl:col-span-5">
                        <img class="h-full w-full object-cover xl:absolute xl:inset-0"
                             src="/img/our-story-bg.png"
                             alt="Our story">
                    </div>
                </div>
            </div>
            <div
                 class="max-w-4xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8 xl:grid xl:grid-cols-2 xl:grid-flow-col-dense xl:gap-x-8">
                <div class="relative py-12 sm:py-24 xl:col-start-1">
                    <h2 class="text-sm font-semibold tracking-wide uppercase">
                        <span class="text-brandGreen-300">
                            {{ __('Our Story') }}
                        </span>
                    </h2>
                    <p class="mt-3 text-3xl font-extrabold text-brandBeige-200">
                        {{ __('Who are the Vegan Linguists?') }}
                    </p>
                    <p class="mt-5 text-xl text-brandBeige-300">
                        {{ __("Vegan Linguists is a project created by the Vegan Hacktivists.  Since the beginning of our journey, we've had hundreds of vegans approach us with the desire to help, but without the technical skills necessary to build software. However, these activists did have something equally as valuable: the ability to speak multiple languages.") }}
                    </p>
                    <p class="mt-5 text-xl text-brandBeige-300">
                        {{ __("We've realized that there are huge accessibility gaps when it comes to information related to veganism, simply due to language barriers. However, there are also many people out there who want to help, but haven't been provided the tools or the opportunity to do so. Knowing these things, it only made sense to build a service that would help multiply the effectiveness of existing work, while also enabling an entirely new group of activists.") }}
                    </p>
                </div>
            </div>
        </div>

        <div class="landing-get-started">
            <div class="flex flex-col gap-12 items-center py-32 px-4 sm:px-6 lg:px-8">
                <h2
                    class="text-brandBeige-100 text-4xl font-extrabold tracking-tight sm:text-4xl space-y-2 text-center">
                    {{ __('Ready to get started?') }}
                </h2>
                <div class="flex flex-col items-center sm:flex-row gap-4 w-full sm:max-w-md">
                    <a href="{{ route('register') }}"
                       class="bg-brandBeige-100 text-brandClay-500 font-bold rounded-md w-3/4 sm:w-1/2 py-2 text-lg text-center">
                        {{ __('Submit content') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="border-2 border-brandBeige-100 text-brandBeige-100 font-bold rounded-md w-3/4 sm:w-1/2 py-2 text-lg text-center">
                        {{ __('Become a translator') }}
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer aria-labelledby="footer-heading">
        <h2 id="footer-heading"
            class="sr-only">{{ __('Footer') }}</h2>
        <div class="max-w-7xl mx-auto pt-16 pb-8 px-4 sm:px-6 lg:pt-24 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                {{ __('Get Active') }}
                            </h3>
                            <ul role="list"
                                class="mt-4 space-y-4">
                                <li>
                                    <a href="https://veganhacktivists.org"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Vegan Hacktivists
                                    </a>
                                </li>

                                <li>
                                    <a href="https://5minutes5vegans.org"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        5 Minutes 5 Vegans
                                    </a>
                                </li>

                                <li>
                                    <a href="https://animalrightsmap.org"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Animal Rights Map
                                    </a>
                                </li>

                                <li>
                                    <a href="https://veganactivism.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Vegan Activism
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                {{ __('Other Projects') }}
                            </h3>
                            <ul role="list"
                                class="mt-4 space-y-4">
                                <li>
                                    <a href="https://activisthub.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Activist Hub
                                    </a>
                                </li>

                                <li>
                                    <a href="https://veganbootcamp.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Vegan Bootcamp
                                    </a>
                                </li>

                                <li>
                                    <a href="https://3movies.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        3 Movies
                                    </a>
                                </li>

                                <li>
                                    <a href="https://dailynooch.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Daily Nooch
                                    </a>
                                </li>

                                <li>
                                    <a href="https://vegancheatsheet.org/"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        Vegan Cheat Sheet
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                {{ __('Get in Touch') }}
                            </h3>
                            <ul role="list"
                                class="mt-4 space-y-4">
                                <li>
                                    <a href="https://www.patreon.com/veganhacktivists"
                                       class="text-base text-gray-500 hover:text-gray-900"
                                       target="_blank">
                                        {{ __('Donate') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="mailto:hello@veganhacktivists.org"
                                       class="text-base text-gray-500 hover:text-gray-900">
                                        {{ __('Contact us') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                {{ __('Legal') }}
                            </h3>
                            <ul role="list"
                                class="mt-4 space-y-4">
                                <li>
                                    <a href="{{ route('policy.show') }}"
                                       class="text-base text-gray-500 hover:text-gray-900">
                                        {{ __('Privacy') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('terms.show') }}"
                                       class="text-base text-gray-500 hover:text-gray-900">
                                        {{ __('Terms') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-12 xl:mt-0">
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                        {{ __('Subscribe to our newsletter') }}
                    </h3>
                    <p class="mt-4 text-base text-gray-500">
                        {{ __("Be the first to know what we're up to.") }}
                    </p>
                    <form class="mt-4 sm:flex sm:max-w-md items-center"
                          action="https://veganhacktivists.us20.list-manage.com/subscribe/post?u=0baba35be8f6397f7ac1066f1&amp;id=5fd11d4221"
                          method="post"
                          target="_blank">
                        <label for="email-address"
                               class="sr-only">{{ __('Email address') }}</label>
                        <x-jet-input type="email"
                                     name="EMAIL"
                                     id="email-address"
                                     autocomplete="email"
                                     required
                                     placeholder="{{ __('Enter your email') }}" />

                        {{-- Bot honey pot --}}
                        <div style="position: absolute; left: -5000px;"
                             aria-hidden="true"><input type="text"
                                   name="b_0baba35be8f6397f7ac1066f1_5fd11d4221"
                                   tabindex="-1"
                                   value=""></div>

                        <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                            <x-jet-button type="submit">
                                {{ __('Subscribe') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between lg:mt-16">
                <div class="flex space-x-6 md:order-2">
                    <a href="https://www.instagram.com/veganhacktivists"
                       class="text-gray-400 hover:text-gray-500"
                       target="_blank">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6"
                             fill="currentColor"
                             viewBox="0 0 24 24"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a href="https://github.com/veganhacktivists"
                       class="text-gray-400 hover:text-gray-500"
                       target="_blank">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6"
                             fill="currentColor"
                             viewBox="0 0 24 24"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                    &copy; {{ date('Y') }} {{ __('Vegan Hacktivists. All rights reserved.') }}
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
