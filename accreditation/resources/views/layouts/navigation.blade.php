<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                   <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                       <i class="fa-solid fa-bars fa-xl"></i>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Off Canvas SideBar -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="bg bg-primary">
                    <div class="mx-auto p-4">
                        <h2 class="fs-2">Pangasinan State University</h2>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                </div>
                <div class="offcanvas-body">
                    <ul class="list-group">
                        <a href="/manage_accreditation">
                            <li class="list-group-item {{ request()->is('manage_accreditation') ? 'active' : '' }}">
                                <i class="fas fa-user"></i> Accreditation
                            </li>
                        </a>
                        @if(Auth::user()->user_type == 'admin') 
                        <a href="/user_list">
                            <li class="list-group-item {{ request()->is('user_list') ? 'active' : '' }}">
                                <i class="fas fa-users"></i> User List
                            </li> 
                        </a>
                        <a href="/add_user">
                            <li class="list-group-item {{ request()->is('add_user') ? 'active' : '' }}">
                                <i class="fas fa-user-plus"></i> Add User
                            </li>
                        </a>
                        <li class="list-group-item {{ request()->is('campus_list') ? 'active' : '' }}">
                            <a href="/campus_list">
                                <i class="fas fa-university"></i> Campuses
                            </a>
                        </li>
                        <li class="list-group-item {{ request()->is('program_list') ? 'active' : '' }}">
                            <a href="/program_list">
                                <i class="fas fa-book"></i> Programs
                            </a>
                        </li>
                        <a href="/instrument_list">
                            <li class="list-group-item {{ request()->is('instrument_list') ? 'active' : '' }}">
                                <i class="fa-solid fa-drum-steelpan"></i> Instruments
                            </li>
                        </a>
                        <!-- <a href="/area_list">
                            <li class="list-group-item {{ request()->is('area_list') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt"></i> Area Management
                            </li>
                        </a>
                        <a href="/parameter_list">
                            <li class="list-group-item {{ request()->is('parameter_list') ? 'active' : '' }}">
                                <i class="fas fa-cogs"></i> Parameter Management
                            </li>
                        </a> -->
                        <a href="/program_level_list">
                            <li class="list-group-item {{ request()->is('program_level_list') ? 'active' : '' }}">
                                <i class="fas fa-file-code"></i> Program Level Management
                            </li>
                        </a>
                        <a href="/indicator_category_list"><li class="list-group-item {{ request()->is('indicator_category_list') ? 'active' : '' }}">
                                <i class="fa-brands fa-confluence"></i> Indicator Category Management
                            </li>
                        </a>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->firstname }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->firstname }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
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
            </div>
        </div>
    </div>
</nav>
