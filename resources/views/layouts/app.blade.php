<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Vegan Linguists') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @stack('styles')
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <script src="{{ mix('js/app.js') }}" defer></script>
        @stack('scripts')
    </head>
    <body class="font-sans bg-gray-100 antialiased">
        <div class="h-screen flex flex-col overflow-hidden">
            @include('navigation-menu')

            <div class="min-h-0 flex-1 flex">
                @if (isset($sidebar))
                    <x-sidebar>
                        {{ $sidebar }}
                    </x-sidebar>
                @endif

                <main class="min-w-0 flex-1 border-t border-gray-200 flex flex-col lg:flex-row overflow-auto">
                    <section aria-labelledby="primary-heading"
                             class="min-w-0 flex-1 {{ !empty($containContent) ? 'h-full' : '' }} flex-col lg:order-last">
                        <x-jet-banner />

                        {{ $slot }}
                    </section>

                    @if (isset($aside))
                        <aside x-data="{ open: false }" class="block flex-shrink-0 order-first">
                            @if (isset($asideTitle))
                                <button @click="open = !open; $el.scrollIntoView()" class="lg:hidden px-2 py-4 flex gap-2 justify-center items-center w-full bg-indigo-50 relative">
                                    {{ $asideTitle }}
                                    <x-heroicon-o-chevron-down class="h-6 w-6" x-bind:class="{ hidden: open }" />
                                    <x-heroicon-o-chevron-up class="h-6 w-6 hidden" x-bind:class="{ hidden: !open }" />
                                </button>
                            @endif

                            <div x-bind:class="{ 'max-h-0': !open, 'max-h-screen': open }"
                                 class="max-h-0 lg:h-full lg:max-h-full transition-all relative flex flex-col lg:w-96 border-r border-gray-200 bg-gray-100 lg:block">
                                {{ $aside }}
                            </div>
                        </aside>
                    @endif
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>

