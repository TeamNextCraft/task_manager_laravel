<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-600 to-teal-700 shadow-xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <x-application-logo class="block h-5 w-auto text-indigo-600" />
                        <span
                            class="text-white font-bold text-xl hidden md:block bg-white/10 px-3 py-1 rounded-lg backdrop-blur-sm">TaskFlow</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="nav-item-dashboard">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-item-dashboard">

                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>

                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" class="nav-item-tasks">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        {{ __('Tasks') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="user-menu-btn inline-flex items-center px-4 py-2.5 border-2 border-white/30 text-sm leading-4 font-semibold rounded-xl text-white bg-white/10 hover:bg-white/20 focus:outline-none transition-all duration-300 backdrop-blur-sm hover:border-white/50">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold mr-2 shadow-lg">
                                    @auth
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @endauth
                                </div>
                                @auth
                                    <div class="max-w-32 truncate font-medium">{{ Auth::user()->name }}</div>
                                @endauth
                            </div>
                            <div class="ms-2 transform transition-transform duration-300">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <span
                                    class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full capitalize">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        @endauth


                        <!-- Authentication -->
                        @auth
                            <x-dropdown-link :href="route('profile.edit')"
                                class="flex items-center py-3 hover:bg-indigo-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                    class="flex items-center py-3 text-rose-600 hover:bg-rose-50 transition-colors duration-200 border-t border-gray-100">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    {{ __('Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')"
                                class="flex items-center py-3 hover:bg-indigo-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                                {{ __('Sign In') }}
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-3 rounded-xl text-indigo-100 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 focus:text-white transition-all duration-300">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-gradient-to-b from-indigo-700 to-teal-800 shadow-2xl max-w-full">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center px-4 py-4 border-l-4 border-indigo-400 hover:bg-white/10 transition-all duration-300 mx-3 rounded-xl">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">{{ __('Dashboard') }}</div>
                    <div class="text-indigo-200 text-sm">Overview & Analytics</div>
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')"
                class="flex items-center px-4 py-4 border-l-4 border-amber-400 hover:bg-white/10 transition-all duration-300 mx-3 rounded-xl">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">{{ __('Tasks') }}</div>
                    <div class="text-indigo-200 text-sm">Manage your work</div>
                </div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-indigo-500 mx-3">
            @if (Auth::check())
                <div class="flex items-center px-4 py-4 bg-white/10 rounded-xl mb-2">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-indigo-200">{{ Auth::user()->email }}</div>
                        <span
                            class="inline-block mt-1 px-2 py-1 text-xs font-medium bg-white/20 text-white rounded-full capitalize">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="mt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="flex items-center px-4 py-3 text-rose-200 hover:text-white hover:bg-white/10 transition-colors duration-200 rounded-lg mx-1">
                    <svg class="w-5 h-5 mr-3 text-indigo-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="flex items-center px-4 py-3 hover:bg-rose-500/20 text-rose-200 hover:text-white transition-colors duration-200 rounded-lg mx-1 border-t border-white/10">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        {{ __('Sign Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-item-dashboard {
        @apply flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 bg-white/0 hover:bg-white/20 text-white border-2 border-transparent;
    }

    .nav-item-dashboard:hover {
        @apply transform -translate-y-0.5 shadow-lg border-white/30;
    }

    .nav-item-dashboard.active {
        @apply bg-white text-indigo-700 shadow-lg border-white transform -translate-y-0.5;
    }

    .nav-item-tasks {
        @apply flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 bg-amber-500/20 hover:bg-amber-500/30 text-white border-2 border-amber-400/30;
    }

    .nav-item-tasks:hover {
        @apply transform -translate-y-0.5 shadow-lg border-amber-400/50 bg-amber-500/40;
    }

    .nav-item-tasks.active {
        @apply bg-amber-500 text-white shadow-lg border-amber-400 transform -translate-y-0.5;
    }

    .user-menu-btn:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    /* Smooth transitions for dropdown */
    .dropdown-content {
        animation: slideDown 0.2s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
