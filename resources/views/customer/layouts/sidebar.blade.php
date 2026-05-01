<section>
    <section class="top-0 bg-slate-900 text-white min-w-48 fixed inset-y-0 left-0 z-50 hidden md:block">

        <header class=" h-[64px] bg-white shadow-lg px-4 md:sticky top-0 z-40">
            <!-- logo -->
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                class="text-white flex items-center space-x-2 group hover:text-white block">
                {{-- <img src="{{ asset('images/logo.jpeg') }}" class=" mr-3" style="height: 55px; margin: 0 auto;"
                    alt="Logo"> --}}
                <x-website-logo />
            </a>
        </header>

        <!-- nav -->
        <nav class="px-4 pt-4 max-h-[calc(100vh-64px)] w-full" x-data="{ selected: 'Tasks' }">
            <ul class="flex flex-col space-y-2 w-full text-sm font-medium">
                <!-- ITEM -->
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="{{ request()->is('*dashboard') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>{{ __('Dashboard') }} </div>
                    </a>
                </li>

                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*profile') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16 9C16 11.2091 14.2091 13 12 13C9.79086 13 8 11.2091 8 9C8 6.79086 9.79086 5 12 5C14.2091 5 16 6.79086 16 9ZM14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z"
                                    fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1ZM3 12C3 14.0902 3.71255 16.014 4.90798 17.5417C6.55245 15.3889 9.14627 14 12.0645 14C14.9448 14 17.5092 15.3531 19.1565 17.4583C20.313 15.9443 21 14.0524 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12ZM12 21C9.84977 21 7.87565 20.2459 6.32767 18.9878C7.59352 17.1812 9.69106 16 12.0645 16C14.4084 16 16.4833 17.1521 17.7538 18.9209C16.1939 20.2191 14.1881 21 12 21Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                        <div>{{ __('Profile') }}</div>
                    </a>
                </li> --}}
                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*membership') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M20 2H4c-1.11 0-2 .89-2 2v11c0 1.11.89 2 2 2h4v5l4-2 4 2v-5h4c1.11 0 2-.89 2-2V4c0-1.11-.89-2-2-2zm0 13H4v-2h16v2zm0-5H4V4h16v6z">
                                </path>
                            </svg>
                        </div>
                        <div>{{ __('Membership') }}</div>
                    </a>
                </li> --}}
                <!-- ITEM -->
                <li>
                    <a href="{{ route('user.workouts.index') }}"
                        class="{{ request()->is('*workouts*') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" color="currentColor">
                                <path d="M18 3V8M6 3V8" stroke="currentColor"></path>
                                <path d="M20.5 4V5.5M20.5 5.5V7M20.5 5.5H22M3.5 4V5.5M3.5 5.5V7M3.5 5.5H2"
                                    stroke="currentColor"></path>
                                <path d="M18 5.5L6 5.5" stroke="currentColor"></path>
                                <path
                                    d="M7.27653 19H16.7235C17.961 19 18.5797 19 18.8356 18.6974C19.4163 18.0107 18.3038 17.1031 17.8979 16.6456C17.4405 16.1302 17.1059 16 16.4299 16H7.57013C6.89408 16 6.55953 16.1302 6.10214 16.6456C5.69617 17.1031 4.58375 18.0107 5.16444 18.6974C5.42026 19 6.03902 19 7.27653 19Z"
                                    stroke="currentColor"></path>
                                <path d="M9 8V16M15 8V16" stroke="currentColor"></path>
                                <path d="M16 19V21M8 19V21" stroke="currentColor"></path>
                            </svg>
                        </div>
                        <div>{{ __('Workouts') }}</div>
                    </a>
                </li>
                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*diet-plan') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                                <path d="M5 19H43V41C43 42.1046 42.1046 43 41 43H7C5.89543 43 5 42.1046 5 41V19Z"
                                    fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                                </path>
                                <path d="M5 10C5 8.89543 5.89543 8 7 8H41C42.1046 8 43 8.89543 43 10V19H5V10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                                <path d="M16 31L22 37L34 25" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M16 5V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M32 5V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </svg>
                        </div>
                        <div>{{ __('Diet-Plan') }}</div>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </section>

    <!-- Mobile menu, show/hide based on menu state. -->
    <section class="md:hidden fixed bg-slate-900 w-full mt-16 pb-8 z-50" id="mobile-menu" x-cloak x-show="mobilemenue"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
        @click.away="mobilemenue = false

       ">
        <!-- nav -->
        <!-- nav -->
        <nav class="px-4 pt-4 max-h-[calc(100vh-64px)] w-full" x-data="{ selected: 'Tasks' }">
            <ul class="flex flex-col space-y-2 w-full text-sm font-medium">
                <!-- ITEM -->
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="{{ request()->is('*dashboard') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-1.5 px-2 rounded">
                        <div class="pr-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>{{ __('Dashboard') }} </div>
                    </a>
                </li>

                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*profile') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-1.5 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16 9C16 11.2091 14.2091 13 12 13C9.79086 13 8 11.2091 8 9C8 6.79086 9.79086 5 12 5C14.2091 5 16 6.79086 16 9ZM14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z"
                                    fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1ZM3 12C3 14.0902 3.71255 16.014 4.90798 17.5417C6.55245 15.3889 9.14627 14 12.0645 14C14.9448 14 17.5092 15.3531 19.1565 17.4583C20.313 15.9443 21 14.0524 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12ZM12 21C9.84977 21 7.87565 20.2459 6.32767 18.9878C7.59352 17.1812 9.69106 16 12.0645 16C14.4084 16 16.4833 17.1521 17.7538 18.9209C16.1939 20.2191 14.1881 21 12 21Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                        <div>{{ __('Profile') }}</div>
                    </a>
                </li> --}}
                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*membership') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M20 2H4c-1.11 0-2 .89-2 2v11c0 1.11.89 2 2 2h4v5l4-2 4 2v-5h4c1.11 0 2-.89 2-2V4c0-1.11-.89-2-2-2zm0 13H4v-2h16v2zm0-5H4V4h16v6z">
                                </path>
                            </svg>
                        </div>
                        <div>{{ __('Membership') }}</div>
                    </a>
                </li> --}}
                {{-- Item --}}
                <li>
                    <a href="{{ route('user.workouts.index') }}"
                        class="{{ request()->is('*workouts*') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" color="currentColor">
                                <path d="M18 3V8M6 3V8" stroke="currentColor"></path>
                                <path d="M20.5 4V5.5M20.5 5.5V7M20.5 5.5H22M3.5 4V5.5M3.5 5.5V7M3.5 5.5H2"
                                    stroke="currentColor"></path>
                                <path d="M18 5.5L6 5.5" stroke="currentColor"></path>
                                <path
                                    d="M7.27653 19H16.7235C17.961 19 18.5797 19 18.8356 18.6974C19.4163 18.0107 18.3038 17.1031 17.8979 16.6456C17.4405 16.1302 17.1059 16 16.4299 16H7.57013C6.89408 16 6.55953 16.1302 6.10214 16.6456C5.69617 17.1031 4.58375 18.0107 5.16444 18.6974C5.42026 19 6.03902 19 7.27653 19Z"
                                    stroke="currentColor"></path>
                                <path d="M9 8V16M15 8V16" stroke="currentColor"></path>
                                <path d="M16 19V21M8 19V21" stroke="currentColor"></path>
                            </svg>
                        </div>
                        <div>{{ __('Workouts') }}</div>
                    </a>
                </li>
                <!-- ITEM -->
                {{-- <li>
                    <a href="{{ route('user.profile.index') }}"
                        class="{{ request()->is('*diet-plan') ? ' text-white bg-orange-600' : 'hover:text-white hover:bg-orange-600' }} flex items-center w-full py-2 px-2 rounded">
                        <div class="pr-2">
                            <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="white" fill-opacity="0.01"></rect>
                                <path d="M5 19H43V41C43 42.1046 42.1046 43 41 43H7C5.89543 43 5 42.1046 5 41V19Z"
                                    fill="currentColor" stroke="currentColor" stroke-width="2"
                                    stroke-linejoin="round">
                                </path>
                                <path d="M5 10C5 8.89543 5.89543 8 7 8H41C42.1046 8 43 8.89543 43 10V19H5V10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                                <path d="M16 31L22 37L34 25" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M16 5V13" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                </path>
                                <path d="M32 5V13" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                </path>
                            </svg>
                        </div>
                        <div>{{ __('Diet-Plan') }}</div>
                    </a>
                </li> --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="py-1.5 px-2">
                        @csrf
                        <button class="flex gap-2">
                            <span>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z">
                                    </path>
                                </svg>
                            </span>
                            <span>
                                {{ __('Log out') }}
                            </span>
                        </button>
                        {{-- <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link> --}}
                    </form>
                </li>
            </ul>
        </nav>
    </section>
</section>
