<nav x-data="{ open: false }" class="border-b border-gray-100 bg-base-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            @guest
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center shrink-0">
                        <a href="{{ url('/') }}">
                            <h1 class="text-xl font-semibold">{{ __('Open Support Ticket Service') }}</h1>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('ticket.create')" :active="request()->routeIs('ticket.create')">
                            {{ __('Open Ticket') }}
                        </x-nav-link>
                        <x-nav-link :href="route('ticket.status.form')" :active="request()->routeIs('ticket.status.form')">
                            {{ __('Check Ticket Status') }}
                        </x-nav-link>
                    </div>
                </div>
                <div class="flex items-center">
                    <label class="swap swap-rotate ms-4">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" class="theme-controller" value="dark" />

                        <!-- sun icon -->
                        <svg class="w-5 h-5 fill-current swap-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                        </svg>

                        <!-- moon icon -->
                        <svg class="w-5 h-5 fill-current swap-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                        </svg>
                    </label>
                    <div class="flex dropdown dropdown-bottom sm:items-center sm:ms-4">
                        <div tabindex="0" role="button" class="m-1 btn btn-ghost">
                            {{ strtoupper(LaravelLocalization::getCurrentLocale()) }}
                        </div>
                        <ul class="p-2 shadow-sm menu dropdown-content bg-base-100 rounded-box z-1 w-52">
                            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $properties)
                                <li><a
                                        href="{{ LaravelLocalization::getLocalizedURL($locale) }}">{{ strtoupper($locale) . ' - ' . $properties['native'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('login') }}"
                        class="hidden btn sm:flex sm:items-center sm:ms-6">{{ __('Login') }}</a>
                </div>
            @endguest
            @auth('web')
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center shrink-0">
                        <a href="{{ route('dashboard') }}">
                            <h1 class="text-xl font-semibold">{{ __('Open Support Ticket Service') }}</h1>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.index')">
                            {{ __('Tickets Management') }}
                        </x-nav-link>
                        @if (Auth::user()->role == 'admin')
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                                {{ __('Category Management') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                {{ __('Users Management') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="flex items-center">
                    <label class="swap swap-rotate">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" class="theme-controller" value="dark" />

                        <!-- sun icon -->
                        <svg class="w-5 h-5 fill-current swap-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                        </svg>

                        <!-- moon icon -->
                        <svg class="w-5 h-5 fill-current swap-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                        </svg>
                    </label>
                    <div class="flex dropdown dropdown-bottom sm:items-center sm:ms-6">
                        <div tabindex="0" role="button" class="m-1 btn btn-ghost">
                            {{ strtoupper(LaravelLocalization::getCurrentLocale()) }}
                        </div>
                        <ul class="p-2 shadow-sm menu dropdown-content bg-base-100 rounded-box z-1 w-52">
                            @foreach (LaravelLocalization::getSupportedLocales() as $locale => $properties)
                                <li><a
                                        href="{{ LaravelLocalization::getLocalizedURL($locale) }}">{{ strtoupper($locale) . ' - ' . $properties['native'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="hidden dropdown dropdown-bottom sm:flex sm:items-center sm:ms-6">
                        <div tabindex="0" role="button" class="m-1 btn">{{ Auth::user()->name }}</div>
                        <ul class="p-2 shadow-sm menu dropdown-content bg-base-100 rounded-box z-1 w-52">
                            <li><a href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            @if (Auth::user()->role == 'admin')
                                <li><a target="_blank" href="{{ route('log-viewer.index') }}">{{ __('Log Viewer') }}</a>
                                </li>
                                @if (config('app.env') != 'production')
                                    <li>
                                        <a href="{{ route('artisan.index') }}">
                                            {{ __('Artisan Commands') }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">{{ __('Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @guest
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ticket.create')" :active="request()->routeIs('ticket.create')">
                    {{ __('Open Ticket') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ticket.status.form')" :active="request()->routeIs('ticket.status.form')">
                    {{ __('Check Ticket Status') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-3 pb-3 border-t border-gray-200">
                <a href="{{ route('login') }}" class="w-full btn sm:flex sm:items-center sm:ms-6">{{ __('Login') }}</a>
                {{-- <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div> --}}
            </div>
        </div>
    @endguest
    @auth('web')
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.index')">
                    {{ __('Tickets Management') }}
                </x-responsive-nav-link>
                @if (auth()->user()->role == 'admin')
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                        {{ __('Category Management') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                        {{ __('Users Management') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (auth()->user()->role == 'admin')
                        <x-responsive-nav-link target="_blank" :href="route('log-viewer.index')">
                            {{ __('Log Viewer') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>
