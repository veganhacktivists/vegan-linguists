@php
$numUnreadNotifications = Auth::user()
    ->unreadNotifications()
    ->count();

$filter = request()->input('filter');
$isOnDashboard = request()->routeIs('home');
@endphp

<header x-data="{ open: false }" x-init="$refs.mobileMenu.classList.remove('hidden')"
  class="relative z-30 flex h-16 flex-shrink-0 items-center bg-brand-beige-100">
  {{-- Logo area --}}
  <div class="absolute inset-y-0 left-0 md:static md:flex-shrink-0">
    <a href="{{ route('home') }}"
      class="flex h-16 items-center justify-center px-4 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-brown-600 md:w-20 md:bg-brand-brown-900">
      <div class="hidden md:block">
        <x-icon-logo-abbreviated class="h-8 w-auto" />
      </div>
      <div class="md:hidden">
        <x-icon-logo-abbreviated-transparent class="h-8 w-auto" />
      </div>
    </a>
  </div>

  {{-- Picker area --}}
  @if (isset($picker))
    <div class="mx-auto md:hidden">
      <div class="relative">
        {{ $picker }}
      </div>
    </div>
  @endif

  {{-- Menu button area --}}
  <div class="absolute inset-y-0 right-0 flex items-center pr-4 sm:pr-6 md:hidden">
    <button type="button"
      class="-mr-2 inline-flex items-center justify-center rounded-md p-2 text-brand-brown-700 hover:border-brand-brown-700 hover:text-brand-brown-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-brown-900"
      @click="open = true">
      <span class="sr-only">{{ __('Open main menu') }}</span>
      <x-heroicon-o-bars-3 class="block h-6 w-6" />
    </button>
  </div>

  {{-- Desktop nav area --}}
  <div class="hidden md:flex md:min-w-0 md:flex-1 md:items-center md:justify-between">
    <a href="{{ route('home') }}" class="ml-4 mt-2">
      <x-icon-logo-text-only class="h-6 w-auto text-brand-clay-400" />
    </a>
    <div class="ml-10 flex flex-shrink-0 items-center space-x-10 pr-4">
      <nav aria-label="{{ __('Global') }}" class="flex space-x-10">
        @if (Auth::user()->isInAuthorMode())
          <x-jet-primary-button element="a" href="{{ route('request-translation') }}" class="text-xs">
            {{ __('Request translation') }}
          </x-jet-primary-button>
        @endif
      </nav>
      <div class="flex items-center space-x-8">
        <span class="inline-flex">
          <a href="{{ route('notifications') }}"
            class="-mx-1 flex rounded-full p-1 text-brand-brown-600 hover:text-brand-brown-800">
            <span class="sr-only">{{ __('View notifications') }}</span>
            <x-heroicon-o-bell class="h-6 w-6" />
            @if ($numUnreadNotifications > 0)
              <x-badge class="bg-brand-clay-500 text-xs text-white" x-data="" x-init="Livewire.on('all-notifications-read', () => $el.remove())">
                {{ $numUnreadNotifications }}
              </x-badge>
            @endif
          </a>
        </span>

        <div class="relative inline-block text-left">
          <div class="hidden sm:flex sm:items-center">
            <div class="relative">
              <x-jet-dropdown align="right" width="48">
                <x-slot name="trigger">
                  <button
                    class="flex rounded-full border-2 border-transparent text-sm transition focus:border-brand-clay-500 focus:outline-none">
                    <x-user-photo :user="Auth::user()" class="h-8 w-8 border-none" />
                  </button>
                </x-slot>

                <x-slot name="content">
                  <div class="block px-4 py-2 text-xs text-brand-brown-500">
                    {{ __('Manage Account') }}
                  </div>

                  <x-jet-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                  </x-jet-dropdown-link>

                  <form method="POST" action="{{ route('switch-user-mode') }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" />

                    <x-jet-dropdown-link href="{{ route('switch-user-mode') }}" x-data=""
                      @click="$event.preventDefault();
                                                             $el.closest('form').submit();">
                      @if (Auth::user()->isInAuthorMode())
                        {{ __('Switch to Translator view') }}
                      @else
                        {{ __('Switch to Author view') }}
                      @endif
                    </x-jet-dropdown-link>
                  </form>

                  <div class="border-t border-brand-beige-100"></div>

                  <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-dropdown-link href="{{ route('logout') }}" x-data=""
                      @click="$event.preventDefault();
                                                             $el.closest('form').submit();">
                      {{ __('Log Out') }}
                    </x-jet-dropdown-link>
                  </form>
                </x-slot>
              </x-jet-dropdown>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- Mobile menu --}}
  <div x-show="open" x-ref="mobileMenu" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 hidden md:hidden" role="dialog" aria-modal="true">

    <div class="hidden sm:fixed sm:inset-0 sm:block sm:bg-brand-brown-900 sm:bg-opacity-50" aria-hidden="true"></div>

    <nav x-show="open" x-transition:enter="transition ease-out duration-150 sm:ease-in-out sm:duration-300"
      x-transition:enter-start="transform opacity-0 scale-110 sm:translate-x-full sm:scale-100 sm:opacity-100"
      x-transition:enter-end="transform opacity-100 scale-100  sm:translate-x-0 sm:scale-100 sm:opacity-100"
      x-transition:leave="transition ease-in duration-150 sm:ease-in-out sm:duration-300"
      x-transition:leave-start="transform opacity-100 scale-100 sm:translate-x-0 sm:scale-100 sm:opacity-100"
      x-transition:leave-end="transform opacity-0 scale-110  sm:translate-x-full sm:scale-100 sm:opacity-100"
      @click.away="open = false"
      class="fixed inset-0 z-40 h-full w-full bg-brand-beige-50 sm:inset-y-0 sm:left-auto sm:right-0 sm:w-full sm:max-w-sm sm:shadow-lg"
      aria-label="{{ __('Global') }}">
      <div class="flex h-16 items-center justify-between px-4 sm:px-6">
        <a href="{{ route('home') }}">
          <x-icon-logo-abbreviated-transparent class="h-8 w-auto" />
        </a>
        <button type="button"
          class="-mr-2 inline-flex items-center justify-center rounded-md p-2 text-brand-brown-700 hover:border-brand-brown-700 hover:text-brand-brown-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-brown-900"
          @click="open = false">
          <span class="sr-only">{{ __('Close main menu') }}</span>
          <x-heroicon-o-x-mark class="block h-6 w-6" />
        </button>
      </div>
      <div class="max-w-8xl mx-auto space-y-1 py-3 px-2 sm:px-4">
        @if (Auth::user()->isInAuthorMode())
          <x-jet-responsive-nav-link href="{{ route('home') }}" :active="empty($filter) && $isOnDashboard">
            {{ __('All Translation Requests') }}
          </x-jet-responsive-nav-link>

          <x-jet-responsive-nav-link href="{{ route('home', ['filter' => 'complete']) }}" :active="$filter === 'complete' && $isOnDashboard">
            {{ __('Completed Translations') }}
          </x-jet-responsive-nav-link>

          <x-jet-responsive-nav-link href="{{ route('home', ['filter' => 'incomplete']) }}" :active="$filter === 'incomplete' && $isOnDashboard">
            {{ __('Incomplete Translation Requests') }}
          </x-jet-responsive-nav-link>

          <x-jet-responsive-nav-link href="{{ route('request-translation') }}" :active="request()->routeIs('request-translation')">
            {{ __('Request Translation') }}
          </x-jet-responsive-nav-link>
        @else
          <x-jet-responsive-nav-link href="{{ route('home', \Request::except('filter')) }}" :active="empty($filter) && $isOnDashboard">
            {{ __('Claimed Requests') }}
          </x-jet-responsive-nav-link>

          <x-jet-responsive-nav-link href=" {{ route('home', ['filter' => 'unclaimed'] + \Request::all()) }}"
            :active="$filter === 'unclaimed' && $isOnDashboard">
            {{ __('Unclaimed Requests') }}
          </x-jet-responsive-nav-link>

          <x-jet-responsive-nav-link href="{{ route('home', ['filter' => 'complete'] + \Request::all()) }}"
            :active="$filter === 'completed' && $isOnDashboard">
            {{ __('Completed Translations') }}
          </x-jet-responsive-nav-link>
        @endif
      </div>
      <div class="border-t border-brand-beige-100 pt-4 pb-3">
        <div class="max-w-8xl mx-auto flex items-center px-4 sm:px-6">
          <div class="flex-shrink-0">
            <x-user-photo :user="Auth::user()" class="h-10 w-10" />
          </div>
          <div class="ml-3 min-w-0 flex-1">
            <div class="truncate text-base text-brand-brown-900">{{ Auth::user()->name }}</div>
            <div class="truncate text-sm text-brand-brown-600">{{ Auth::user()->email }}</div>
          </div>
          <a href="{{ route('notifications') }}"
            class="ml-auto flex flex-shrink-0 p-2 text-brand-brown-600 hover:text-brand-brown-800">
            <span class="sr-only">{{ __('View notifications') }}</span>
            <x-heroicon-o-bell class="h-6 w-6" />
            @if ($numUnreadNotifications > 0)
              <x-badge class="bg-brand-clay-500 text-xs text-white" x-data="" x-init="Livewire.on('all-notifications-read', () => $el.remove())">
                {{ $numUnreadNotifications }}
              </x-badge>
            @endif
          </a>
        </div>
        <div class="max-w-8xl mx-auto mt-3 space-y-1 px-2 sm:px-4">
          <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
            {{ __('Profile') }}
          </x-jet-responsive-nav-link>

          <form method="POST" action="{{ route('switch-user-mode') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT" />

            <x-jet-responsive-nav-link href="{{ route('switch-user-mode') }}" x-data=""
              @click="$event.preventDefault();
                                                   $el.closest('form').submit();">
              @if (Auth::user()->isInAuthorMode())
                {{ __('Switch to Translator view') }}
              @else
                {{ __('Switch to Author view') }}
              @endif
            </x-jet-responsive-nav-link>
          </form>

          <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-jet-responsive-nav-link href="{{ route('logout') }}" x-data=""
              @click="$event.preventDefault();
                                                   $el.closest('form').submit();">
              {{ __('Log Out') }}
            </x-jet-responsive-nav-link>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>
