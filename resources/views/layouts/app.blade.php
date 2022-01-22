<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @if (isset($pageTitle))
            {{ $pageTitle }} |
        @endif

        {{ config('app.name', 'Vegan Linguists') }}
    </title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    @stack('styles')
    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}">

    @livewireStyles

    <x-google-analytics />
    <script src="{{ mix('js/app.js') }}"
            defer></script>
    @stack('scripts')
</head>

<body class="font-sans antialiased bg-brand-beige-100 bg-opacity-60 text-brand-brown-900">
    <div class="h-screen flex flex-col overflow-hidden">
        @include('navigation-menu')

        @php
            $filter = request()->input('filter');
            $isOnTranslationRequestsPage = request()->routeIs('translation-requests.index');
            $isOnDashboard = request()->routeIs('home');
        @endphp
        <div class="min-h-0 flex-1 flex">
            <nav aria-label="Sidebar"
                 class="hidden md:block md:flex-shrink-0 md:bg-brand-brown-900 md:overflow-y-auto">
                <div class="relative w-20 p-3 flex flex-col space-y-3 justify-between h-full">
                    <div class="flex flex-col space-y-3">
                        <x-sidebar-link href="{{ route('home') }}"
                                        icon="o-home"
                                        :active="empty($filter) && $isOnDashboard">
                            {{ __('Dashboard') }}
                        </x-sidebar-link>

                        <x-sidebar-separator />

                        @if (Auth::user()->isInAuthorMode())
                            <x-sidebar-link href="{{ route('home', ['filter' => 'incomplete']) }}"
                                            icon="o-folder-open"
                                            :active="$filter === 'incomplete' && $isOnDashboard">
                                {{ __('My Translation Requests') }}
                            </x-sidebar-link>

                            <x-sidebar-link href="{{ route('home', ['filter' => 'complete']) }}"
                                            :active="$filter === 'complete' && $isOnDashboard"
                                            icon="o-check">
                                {{ __('Completed Translations') }}
                            </x-sidebar-link>
                        @else
                            <x-sidebar-link href="{{ unclaimedTranslationRequestsRoute() }}"
                                            :active="empty($filter) && $isOnTranslationRequestsPage"
                                            icon="o-search">
                                {{ __('Browse Translation Requests') }}
                            </x-sidebar-link>

                            <x-sidebar-link href="{{ claimedTranslationRequestsRoute() }}"
                                            :active="$filter === 'mine' && $isOnTranslationRequestsPage"
                                            icon="o-document-text">
                                {{ __('My Translations') }}
                            </x-sidebar-link>

                            <x-sidebar-separator />

                            <x-sidebar-link href="{{ reviewableTranslationRequestsRoute() }}"
                                            :active="$filter === 'reviewable' && $isOnTranslationRequestsPage"
                                            icon="o-document-search">
                                {{ __('Browse Reviewable Translations') }}
                            </x-sidebar-link>

                            <x-sidebar-link href="{{ underReviewTranslationRequestsRoute() }}"
                                            :active="$filter === 'under-review' && $isOnTranslationRequestsPage"
                                            icon="o-switch-horizontal">
                                {{ __('Translations Under Review') }}
                            </x-sidebar-link>

                            <x-sidebar-separator />

                            <x-sidebar-link href="{{ completedTranslationRequestsRoute() }}"
                                            :active="$filter === 'completed' && $isOnTranslationRequestsPage"
                                            icon="o-check">
                                {{ __('Completed Translations') }}
                            </x-sidebar-link>
                        @endif
                    </div>
                    <x-sidebar-link href="https://veganhacktivists.org/contact"
                                    class="justify-self-end"
                                    target="_blank"
                                    icon="o-at-symbol">
                        {{ __('Contact Us') }}
                    </x-sidebar-link>
            </nav>

            <main class="min-w-0 flex-1 border-t border-brand-brown-200 flex flex-col lg:flex-row overflow-auto">
                <section aria-labelledby="primary-heading"
                         class="min-w-0 flex-1 {{ !empty($containContent) ? 'h-full' : '' }} flex-col lg:order-last">
                    <x-jet-banner />

                    {{ $slot }}
                </section>

                @if (isset($aside))
                    <aside x-data="{ open: false }"
                           class="block flex-shrink-0 order-first">
                        @if (isset($asideTitle))
                            <button @click="open = !open; $el.scrollIntoView()"
                                    class="lg:hidden px-2 py-4 flex gap-2 justify-center items-center w-full bg-brand-clay-50 relative">
                                {{ $asideTitle }}
                                <x-heroicon-o-chevron-down class="h-6 w-6"
                                                           x-bind:class="{ hidden: open }" />
                                <x-heroicon-o-chevron-up class="h-6 w-6 hidden"
                                                         x-bind:class="{ hidden: !open }" />
                            </button>
                        @endif

                        <div x-bind:class="{ 'max-h-0': !open, 'max-h-screen': open }"
                             class="max-h-0 lg:h-full lg:max-h-full transition-all relative flex flex-col lg:w-96 border-b lg:border-b-none lg:border-r border-brand-brown-200 bg-brand-beige-50 lg:block">
                            {{ $aside }}
                        </div>
                    </aside>
                @endif
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="{{ mix('js/livewire-turbolinks.js') }}"
            data-turbolinks-eval="false"></script>
</body>

</html>
