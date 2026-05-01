<header class="bg-white shadow top-0 text-black w-full z-50 inset-x-0 fixed" x-data="{ mobilemenue: false }">
    <div class="mx-auto">
        <div class="flex flex-row-reverse md:flex-row items-stretch justify-between h-16 px-4 md:px-0">
            <div class="flex items-center md:hidden">
                <div class="-mr-2 flex" x-data>
                    <!-- Mobile menu button -->
                    <button type="button" @click="$dispatch('togglemenubar')"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>

                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="text-white flex items-center space-x-2 group ml-5">
                        <x-website-logo />
                    </a>
                </div>

                {{-- <!-- toggel sidebar -->
                <div class="text-white cursor-pointer hidden md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div> --}}
            </div>
            <div class="hidden md:flex items-stretch">
                <!-- Profile Menu DT -->
                <div class="ml-4 flex md:ml-6 ">
                    <!-- Profile dropdown -->
                    <div class="relative bg-white px-4 text-black text-sm cursor-pointer" x-data="{ open: false }">
                        <div class="flex items-center min-h-full" @click="open = !open">
                            <img src="{{ profileImage(auth()->user()->image->path) }}" alt=""
                                class="rounded-full w-10 h-10">
                            <div class="flex  gap-2 items-center ml-4">
                                <span>{{ __(auth()->user()->userProfile->fullName) }}</span>
                                <span>
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490 480"
                                        fill="currentColor">
                                        <title>down</title>
                                        <path d="M250 360l180-180-30-30-150 150-160-150-30 30 190 180z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div x-show="open" x-cloak @click.away="open = false"
                            class="z-50 origin-top-right absolute right-1 mt-0 min-w-full rounded-b-md shadow py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none border"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95" role="menu"
                            aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="{{ route(auth()->user()->roleName . 'profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">
                                {{ __('My Profile') }}
                            </a>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
