<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    @if (isset($pageTitle))
      {{ $pageTitle }} |
    @endif

    {{ config('app.name', 'Vegan Linguists') }}
  </title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  {{-- Scripts --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Styles --}}
  @livewireStyles


  <x-google-analytics />
</head>

<body class="bg-brand-beige-100 bg-opacity-60 font-sans text-brand-brown-900 antialiased">
  <div class="flex h-screen flex-col overflow-hidden">
    @include('navigation-menu')

    @php
      $filter = request()->input('filter');
      $isOnTranslationRequestsPage = request()->routeIs('translation-requests.index');
      $isOnDashboard = request()->routeIs('home');
    @endphp
    <div class="flex min-h-0 flex-1">
      <nav aria-label="Sidebar" class="hidden md:block md:flex-shrink-0 md:overflow-y-auto md:bg-brand-brown-900">
        <div class="relative flex h-full w-20 flex-col justify-between space-y-3 p-3">
          <div class="flex flex-col space-y-3">
            <x-sidebar-link href="{{ route('home') }}" icon="o-home" :active="empty($filter) && $isOnDashboard">
              {{ __('Dashboard') }}
            </x-sidebar-link>

            <x-sidebar-separator />

            @if (Auth::user()->isInAuthorMode())
              <x-sidebar-link href="{{ route('home', ['filter' => 'incomplete']) }}" icon="o-folder-open"
                :active="$filter === 'incomplete' && $isOnDashboard">
                {{ __('My Translation Requests') }}
              </x-sidebar-link>

              <x-sidebar-link href="{{ route('home', ['filter' => 'complete']) }}" :active="$filter === 'complete' && $isOnDashboard" icon="o-check">
                {{ __('Completed Translations') }}
              </x-sidebar-link>
            @else
              <x-sidebar-link href="{{ unclaimedTranslationRequestsRoute() }}" :active="empty($filter) && $isOnTranslationRequestsPage" icon="o-magnifying-glass">
                {{ __('Browse Translation Requests') }}
              </x-sidebar-link>

              <x-sidebar-link href="{{ claimedTranslationRequestsRoute() }}" :active="$filter === 'mine' && $isOnTranslationRequestsPage" icon="o-document-text">
                {{ __('My Translations') }}
              </x-sidebar-link>

              <x-sidebar-separator />

              <x-sidebar-link href="{{ reviewableTranslationRequestsRoute() }}" :active="$filter === 'reviewable' && $isOnTranslationRequestsPage"
                icon="o-document-magnifying-glass">
                {{ __('Browse Reviewable Translations') }}
              </x-sidebar-link>

              <x-sidebar-link href="{{ underReviewTranslationRequestsRoute() }}" :active="$filter === 'under-review' && $isOnTranslationRequestsPage"
                icon="o-arrows-right-left">
                {{ __('Translations Under Review') }}
              </x-sidebar-link>

              <x-sidebar-separator />

              <x-sidebar-link href="{{ completedTranslationRequestsRoute() }}" :active="$filter === 'completed' && $isOnTranslationRequestsPage" icon="o-check">
                {{ __('Completed Translations') }}
              </x-sidebar-link>
            @endif
          </div>
          <x-sidebar-link href="https://veganhacktivists.org/contact" class="justify-self-end" target="_blank"
            icon="o-at-symbol">
            {{ __('Contact Us') }}
          </x-sidebar-link>
      </nav>

      <main class="flex min-w-0 flex-1 flex-col overflow-auto border-t border-brand-brown-200 lg:flex-row">
        <section aria-labelledby="primary-heading"
          class="{{ !empty($containContent) ? 'h-full' : '' }} min-w-0 flex-1 flex-col lg:order-last">
          <x-banner />

          {{ $slot }}
        </section>

        @if (isset($aside))
          <aside x-data="{ open: false }" class="order-first block flex-shrink-0">
            @if (isset($asideTitle))
              <button @click="open = !open; $el.scrollIntoView()"
                class="relative flex w-full items-center justify-center gap-2 bg-brand-clay-50 px-2 py-4 lg:hidden">
                {{ $asideTitle }}
                <x-heroicon-o-chevron-down class="h-6 w-6" x-bind:class="{ hidden: open }" />
                <x-heroicon-o-chevron-up class="hidden h-6 w-6" x-bind:class="{ hidden: !open }" />
              </button>
            @endif

            <div x-bind:class="{ 'max-h-0': !open, 'max-h-screen': open }"
              class="lg:border-b-none relative flex max-h-0 flex-col border-b border-brand-brown-200 bg-brand-beige-50 transition-all lg:block lg:h-full lg:max-h-full lg:w-96 lg:border-r">
              {{ $aside }}
            </div>
          </aside>
        @endif
      </main>
    </div>
  </div>

  <x-cookie-banner />
  @stack('modals')

 @livewireScripts
</body>

</html>
