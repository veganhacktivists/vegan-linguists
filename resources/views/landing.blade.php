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

    <x-google-analytics />
</head>

<body>
    <header>
        <div class="relative bg-brand-brown-900">
            <div
                 class="flex justify-between items-center max-w-7xl mx-auto px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="{{ route('home') }}">
                        <span class="sr-only">Vegan Linguists</span>
                        <x-icon-logo-text-only class="h-5 -mb-2 w-auto sm:h-8 sm:-mb-3 text-brand-beige-100" />
                    </a>
                </div>

                <div class=" flex items-center justify-end md:flex-1 lg:w-0">
                    <a href="{{ route('login') }}"
                       class="whitespace-nowrap text-base text-brand-beige-300 hover:text-brand-beige-100 font-bold">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex ml-4 sm:ml-8 whitespace-nowrap items-center justify-center bg-brand-clay-500 hover:bg-brand-clay-600 px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-bold text-white">
                        {{ __('Sign up') }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="landing-hero">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative px-4 py-16 sm:px-6 lg:px-8">
                    <x-icon-logo-with-text class="h-40 sm:h-64 mx-auto max-w-full" />
                    <h1 class="text-center font-extrabold tracking-tight text-3xl mt-5">
                        {{ __('Have vegan content? Get it translated.') }}
                    </h1>
                    <p class="mt-6 max-w-lg mx-auto text-center text-xl sm:max-w-xl">
                        {{ __('Vegan Linguists is a free content translation service run by vegans, for vegans. We translate vegan-friendly content to help make veganism more accessible worldwide!') }}
                    </p>
                    <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center">
                        <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-4">
                            <x-jet-primary-button element="a"
                                                  class="flex justify-center"
                                                  href="{{ route('register') }}">
                                {{ __('Get content translated') }}
                            </x-jet-primary-button>
                            <a href="{{ route('register') }}"
                               class="flex items-center justify-center px-3 py-2 border border-transparent text-base rounded-md shadow-sm text-white bg-brand-clay-500 hover:bg-brand-clay-600 font-bold">
                                {{ __('Translate content') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="landing-video-section md:pt-4 md:pb-8 md:px-16 lg:pt-6 lg:pb-10 lg:px-32 xl:px-48">
            <h2 class="hidden md:block text-white text-center text-2xl lg:text-3xl font-semibold mb-3 lg:mb-6">
                {{ __('Build bridges across languages and cultures') }}
            </h2>

            <iframe class="w-full aspect-video max-w-7xl mx-auto"
                    src="https://www.youtube.com/embed/4ff-UfXfumM?rel=0&modestbranding=1"
                    title="{{ __('Vegan Linguists introduction video') }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
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
                            <p class="mt-4 text-lg">
                                {{ __("Our team of translators will translate your content for free. All you need to do is sign up and submit your content. We'll take care of the rest.") }}
                            </p>
                            <div class="mt-6">
                                <x-jet-primary-button element="a"
                                                      href="{{ route('register') }}">
                                    {{ __('Get started') }}
                                </x-jet-primary-button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0">
                        <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-144">
                            <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-144 lg:w-auto lg:max-w-none"
                                 src="/img/screenshot-author.png"
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
                            <p class="mt-4 text-lg text-brand-brown-800">
                                {{ __('If you speak more than one language, you can help the vegan movement from the comfort of your own home. Your activism will help make vegan content more accessible around the world.') }}
                            </p>
                            <p class="mt-4 text-lg text-brand-brown-800">
                                {{ __('We need your help to build bridges across languages and cultures. Register to find vegan content that needs to be translated to the languages you speak.') }}
                            </p>
                            <div class="mt-6">
                                <x-jet-primary-button element="a"
                                                      href="{{ route('register') }}">
                                    {{ __('Get started') }}
                                </x-jet-primary-button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                        <div class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                            <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                                 src="/img/screenshot-translator.png"
                                 alt="{{ __('Translator interface') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative bg-brand-brown-900">
            <div class="hidden lg:block h-80 absolute inset-x-0 bottom-0 lg:top-0 lg:h-full">
                <div class="h-full w-full lg:grid lg:grid-cols-12">
                    <div class="h-full lg:relative lg:col-start-8 lg:col-span-5 bg-noise">
                        <img class="h-full w-full lg:p-8 xl:p-20 object-contain lg:absolute lg:inset-0"
                             src="/img/animals-talking.png"
                             alt="Our story">
                    </div>
                </div>
            </div>
            <div
                 class="max-w-4xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-x-8">
                <div class="relative py-12 sm:py-24 lg:col-start-1">
                    <h2 class="text-sm font-semibold tracking-wide uppercase">
                        <span class="text-brand-green-300">
                            {{ __('Our Story') }}
                        </span>
                    </h2>
                    <p class="mt-3 text-3xl font-extrabold text-brand-beige-200">
                        {{ __('Who are the Vegan Linguists?') }}
                    </p>
                    <p class="mt-5 text-xl text-brand-beige-300">
                        {!! __("Vegan Linguists is a project created by the :veganHacktivists.  Since the beginning of our journey, we've had hundreds of vegans approach us with the desire to help, but without the technical skills necessary to build software. However, these activists did have something equally as valuable: the ability to speak multiple languages.", [
    'veganHacktivists' => '<a href="https://veganhacktivists.org" target="_blank" class="text-brand-green-400 hover:text-brand-green-500">Vegan Hacktivists</a>',
]) !!}
                    </p>
                    <p class="mt-5 text-xl text-brand-beige-300">
                        {{ __("We've realized that there are huge accessibility gaps when it comes to information related to veganism, simply due to language barriers. However, there are also many people out there who want to help, but haven't been provided the tools or the opportunity to do so. Knowing these things, it only made sense to build a service that would help multiply the effectiveness of existing work, while also enabling an entirely new group of activists.") }}
                    </p>
                </div>
            </div>
        </div>

        <div class="landing-get-started">
            <div class="flex flex-col gap-12 items-center py-32 px-4 sm:px-6 lg:px-8">
                <h2
                    class="text-brand-beige-100 text-4xl font-extrabold tracking-tight sm:text-4xl space-y-2 text-center">
                    {{ __('Ready to get started?') }}
                </h2>
                <div class="flex flex-col items-center sm:flex-row gap-4 w-full sm:max-w-md">
                    <a href="{{ route('register') }}"
                       class="border-2 border-brand-beige-100 bg-brand-beige-100 hover:bg-brand-beige-200 hover:border-brand-beige-200 text-brand-clay-500 font-bold rounded-md w-3/4 sm:w-1/2 py-2 text-lg text-center">
                        {{ __('Submit content') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="border-2 border-brand-beige-100 text-brand-beige-100 hover:bg-brand-beige-100 hover:text-brand-clay-500 font-bold rounded-md w-3/4 sm:w-1/2 py-2 text-lg text-center">
                        {{ __('Become a translator') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-brand-green-400">
            <div
                 class="max-w-7xl w-5/6 md:w-auto mx-auto text-white flex flex-col md:flex-row justify-between md:items-center py-8 md:px-6 lg:px-8 gap-6 text-center md:text-left">
                <div class="flex gap-6">
                    <x-icon-patreon class="h-16 w-16 hidden md:inline-block" />
                    <div class="flex flex-col gap-2">
                        <h4 class="text-2xl">{{ __('Please consider supporting us on Patreon!') }}</h4>
                        <p class="text-xl">
                            {{ __('This free-to-use service would not be possible without your support. Thank you!') }}
                        </p>
                    </div>
                </div>
                <div>
                    <a href="https://patreon.com/veganhacktivists"
                       target="_blank"
                       class=" bg-white hover:bg-brand-green-50 text-brand-green-400 font-bold rounded-md px-8 py-2 text-lg text-center whitespace-nowrap">
                        {{ __('Support us') }}
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
                          action="https://veganhacktivists.us20.list-manage.com/subscribe/post?u=0baba35be8f6397f7ac1066f1&amp;id=f4cb014082"
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
                        <x-icon-instagram class="h-6 w-6" />
                    </a>

                    <a href="https://github.com/veganhacktivists"
                       class="text-gray-400 hover:text-gray-500"
                       target="_blank">
                        <span class="sr-only">GitHub</span>
                        <x-icon-github class="h-6 w-6" />
                    </a>
                </div>
                <p class="mt-8 text-base text-gray-500 md:mt-0 md:order-1">
                    &copy; {{ date('Y') }} {{ __('Vegan Hacktivists. All rights reserved.') }}
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
