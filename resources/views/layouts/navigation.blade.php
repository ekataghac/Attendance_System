<nav x-data="{ open: false }" class="navigation dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->


    <div class=" px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between h-16">
            <div class="flex">
            <div class="hamburger2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <button class="Tooglebutton btn btn-primary" id="menu-toggle">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="dropdown hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->first_name  }} {{ Auth::user()->last_name }}</div>

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
            <div class="hamburger -mr-2 flex items-center sm:hidden"><h2>{{ Auth::user()->name }}</h2>
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @cannot('user')
            <x-responsive-nav-link :href="route('employeecrud')" :active="request()->routeIs('employeecrud')">
                {{ __('Edit Details') }}
            </x-responsive-nav-link>
            @endcannot
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('leaveRequest')">
                {{ __('Leave') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('report')">
                {{ __('Reports') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('leaveCalender')" :active="request()->routeIs('leaveCalender')">
                {{ __('Calender') }}
            </x-responsive-nav-link>
        </div>
    </div>
    

</nav>    

        <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <img class="ProfilePic" src="{{ asset('storage/images/' . Auth::user()->image) }}" alt="Profile picture">
        <div class="sidebar-heading">{{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}</div>
        <div class="list-group list-group-flush">
            <div class="navl list-group-item list-group-item-action bg-light">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link></a>
            </div>@cannot('user')
            <div class="navl list-group-item list-group-item-action bg-light">
                    
                    <x-nav-link :href="route('employeecrud')" :active="request()->routeIs('employeecrud')">
                        {{ __('Edit Details') }}
                    </x-nav-link>
                   
            </div> @endcannot
            <div class="navl list-group-item list-group-item-action bg-light">
                <x-nav-link :href="route('leaveRequest')" :active="request()->routeIs('leaveRequest')">
                        {{ __('Leave') }}
                    </x-nav-link>
            </div>
            <div class="navl list-group-item list-group-item-action bg-light">
                <x-nav-link :href="route('report')" :active="request()->routeIs('report')">
                        {{ __('Reports') }}
                </x-nav-link>
            </div>
            <div class="navl list-group-item list-group-item-action bg-light">
                <x-nav-link :href="route('leaveCalender')" :active="request()->routeIs('leaveCalender')">
                        {{ __('Calender') }}
                </x-nav-link>
            </div>

        </div>
</div>

