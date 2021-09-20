@php
$numUnreadNotifications = Auth::user()
    ->unreadNotifications()
    ->count();

$filter = request()->input('filter');
$isOnDashboard = request()->routeIs('home');
@endphp

<header x-data="{ open: false }"
        x-init="$refs.mobileMenu.classList.remove('hidden')"
        class="flex-shrink-0 relative h-16 bg-brandBeige-100 flex items-center">
    {{-- Logo area --}}
    <div class="absolute inset-y-0 left-0 md:static md:flex-shrink-0">
        <a href="{{ route('home') }}"
           class="flex items-center justify-center h-16 px-4 md:bg-brandBrown-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brandBrown-600 md:w-20">
            <x-icon-logo-abbreviated class="h-8 w-auto" />
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
    <div class="absolute inset-y-0 right-0 pr-4 flex items-center sm:pr-6 md:hidden">
        <button type="button"
                class="-mr-2 inline-flex items-center justify-center p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset text-brandBrown-700 hover:border-brandBrown-700 hover:text-brandBrown-900 focus:ring-brandBrown-900"
                @click="open = true">
            <span class="sr-only">{{ __('Open main menu') }}</span>
            <x-heroicon-o-menu class="block h-6 w-6" />
        </button>
    </div>

    {{-- Desktop nav area --}}
    <div class="hidden md:min-w-0 md:flex-1 md:flex md:items-center md:justify-end">
        <div class="ml-10 pr-4 flex-shrink-0 flex items-center space-x-10">
            <nav aria-label="{{ __('Global') }}"
                 class="flex space-x-10">
                @if (Auth::user()->isInAuthorMode())
                    <x-jet-nav-link href="{{ route('request-translation') }}"
                                    :active="request()->routeIs('request-translation')">
                        {{ __('Request Translation') }}
                    </x-jet-nav-link>
                @endif
            </nav>
            <div class="flex items-center space-x-8">
                <span class="inline-flex">
                    <a href="{{ route('notifications') }}"
                       class="-mx-1 p-1 rounded-full text-brandBrown-600 hover:text-brandBrown-800 flex">
                        <span class="sr-only">{{ __('View notifications') }}</span>
                        <x-heroicon-o-bell class="h-6 w-6" />
                        @if ($numUnreadNotifications > 0)
                            <x-badge class="bg-brandClay-500 text-white"
                                     x-data=""
                                     x-init="Livewire.on('all-notifications-read', () => $el.remove())">
                                {{ $numUnreadNotifications }}
                            </x-badge>
                        @endif
                    </a>
                </span>

                <div class="relative inline-block text-left">
                    <div class="hidden sm:flex sm:items-center">
                        <div class="relative">
                            <x-jet-dropdown align="right"
                                            width="48">
                                <x-slot name="trigger">
                                    <button
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-brandBrown-800 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}"
                                             alt="{{ Auth::user()->name }}" />
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="block px-4 py-2 text-xs text-brandBrown-500">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-jet-dropdown-link>

                                    <form method="POST"
                                          action="{{ route('switch-user-mode') }}">
                                        @csrf
                                        <input type="hidden"
                                               name="_method"
                                               value="PUT" />

                                        <x-jet-dropdown-link href="{{ route('switch-user-mode') }}"
                                                             onclick="event.preventDefault();
                                                             this.closest('form').submit();">
                                            @if (Auth::user()->isInAuthorMode())
                                                {{ __('Switch to Translator view') }}
                                            @else
                                                {{ __('Switch to Author view') }}
                                            @endif
                                        </x-jet-dropdown-link>
                                    </form>

                                    <div class="border-t border-brandBeige-100"></div>

                                    <form method="POST"
                                          action="{{ route('logout') }}">
                                        @csrf

                                        <x-jet-dropdown-link href="{{ route('logout') }}"
                                                             onclick="event.preventDefault();
                                                             this.closest('form').submit();">
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
    <div x-show="open"
         x-ref="mobileMenu"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 md:hidden hidden"
         role="dialog"
         aria-modal="true">

        <div class="hidden sm:block sm:fixed sm:inset-0 sm:bg-brandBeige-200 sm:bg-opacity-75"
             aria-hidden="true"></div>

        <nav x-show="open"
             x-transition:enter="transition ease-out duration-150 sm:ease-in-out sm:duration-300"
             x-transition:enter-start="transform opacity-0 scale-110 sm:translate-x-full sm:scale-100 sm:opacity-100"
             x-transition:enter-end="transform opacity-100 scale-100  sm:translate-x-0 sm:scale-100 sm:opacity-100"
             x-transition:leave="transition ease-in duration-150 sm:ease-in-out sm:duration-300"
             x-transition:leave-start="transform opacity-100 scale-100 sm:translate-x-0 sm:scale-100 sm:opacity-100"
             x-transition:leave-end="transform opacity-0 scale-110  sm:translate-x-full sm:scale-100 sm:opacity-100"
             @click.away="open = false"
             class="fixed z-40 inset-0 h-full w-full bg-brandBeige-50 sm:inset-y-0 sm:left-auto sm:right-0 sm:max-w-sm sm:w-full sm:shadow-lg"
             aria-label="{{ __('Global') }}">
            <div class="h-16 flex items-center justify-between px-4 sm:px-6">
                <a href="{{ route('home') }}">
                    <x-icon-logo-abbreviated class="h-8 w-auto" />
                </a>
                <button type="button"
                        class="-mr-2 inline-flex items-center justify-center p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset text-brandBrown-700 hover:border-brandBrown-700 hover:text-brandBrown-900 focus:ring-brandBrown-900"
                        @click="open = false">
                    <span class="sr-only">{{ __('Close main menu') }}</span>
                    <x-heroicon-o-x class="block h-6 w-6" />
                </button>
            </div>
            <div class="max-w-8xl mx-auto py-3 px-2 sm:px-4 space-y-1">
                @if (Auth::user()->isInAuthorMode())
                    <x-jet-responsive-nav-link href="{{ route('home') }}"
                                               :active="empty($filter) && $isOnDashboard">
                        {{ __('All Translation Requests') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('home', ['filter' => 'complete']) }}"
                                               :active="$filter === 'complete' && $isOnDashboard">
                        {{ __('Completed Translations') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('home', ['filter' => 'incomplete']) }}"
                                               :active="$filter === 'incomplete' && $isOnDashboard">
                        {{ __('Incomplete Translation Requests') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('request-translation') }}"
                                               :active="request()->routeIs('request-translation')">
                        {{ __('Request Translation') }}
                    </x-jet-responsive-nav-link>
                @else
                    <x-jet-responsive-nav-link href="{{ route('home', \Request::except('filter')) }}"
                                               :active="empty($filter) && $isOnDashboard">
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
            <div class="border-t border-brandBeige-100 pt-4 pb-3">
                <div class="max-w-8xl mx-auto px-4 flex items-center sm:px-6">
                    <div class="flex-shrink-0">
                        <x-user-photo :user="Auth::user()"
                                      class="h-10 w-10" />
                    </div>
                    <div class="ml-3 min-w-0 flex-1">
                        <div class="text-base text-brandBrown-900 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-brandBrown-600 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <a href="{{ route('notifications') }}"
                       class="ml-auto flex-shrink-0 p-2 text-brandBrown-600 hover:text-brandBrown-800 flex">
                        <span class="sr-only">{{ __('View notifications') }}</span>
                        <x-heroicon-o-bell class="h-6 w-6" />
                        @if ($numUnreadNotifications > 0)
                            <x-badge class="bg-brandClay-500 text-white"
                                     x-data=""
                                     x-init="Livewire.on('all-notifications-read', () => $el.remove())">
                                {{ $numUnreadNotifications }}
                            </x-badge>
                        @endif
                    </a>
                </div>
                <div class="mt-3 max-w-8xl mx-auto px-2 space-y-1 sm:px-4">
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                                               :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-jet-responsive-nav-link>

                    <form method="POST"
                          action="{{ route('switch-user-mode') }}">
                        @csrf
                        <input type="hidden"
                               name="_method"
                               value="PUT" />

                        <x-jet-responsive-nav-link href="{{ route('switch-user-mode') }}"
                                                   onclick="event.preventDefault();
                                                             this.closest('form').submit();">
                            @if (Auth::user()->isInAuthorMode())
                                {{ __('Switch to Translator view') }}
                            @else
                                {{ __('Switch to Author view') }}
                            @endif
                        </x-jet-responsive-nav-link>
                    </form>

                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>
