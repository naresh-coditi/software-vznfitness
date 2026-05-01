<section x-data="sidebar" x-on:togglemenubar.window="mobilemenue = !mobilemenue" x-cloak>
    <section class="top-0 bg-white text-black min-w-52 shadow-lg fixed inset-y-0 left-0 z-50 hidden md:block">

        <header class=" h-[64px] bg-white   px-4 md:sticky top-0 z-40">
            <!-- logo -->
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                class="text-white flex items-center space-x-2 group hover:text-white">
                {{-- <img src="{{ asset('images/logo.jpeg') }}" class=" mr-3" style="height: 55px; margin: 0 auto;"
                    alt="Logo"> --}}
                <x-website-logo />
            </a>
        </header>

        <!-- nav -->
        <nav class="px-4 pt-4 max-h-[calc(100vh-64px)] w-full">
            <ul class="flex flex-col space-y-2 w-full text-sm font-medium leading-7">
                <!-- ITEM -->
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="{{ request()->is('*dashboard') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded">
                        <div class="pr-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>{{ __('Dashboard') }} </div>
                    </a>
                </li>
                <li>
                    <button @click="open = (open == 'users' ? null : 'users')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                </path>
                            </svg>
                            {{ __('Users') }}
                        </span>
                        <span x-show="open == 'users'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'users'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'users'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.index') }}"
                                class="{{ request()->is('*/members*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"
                                        fill="currentColor">
                                        <path
                                            d="M5.5 0a3.499 3.499 0 100 6.996A3.499 3.499 0 105.5 0zm-2 8.994a3.5 3.5 0 00-3.5 3.5v2.497h11v-2.497a3.5 3.5 0 00-3.5-3.5h-4zm9 1.006H12v5h3v-2.5a2.5 2.5 0 00-2.5-2.5z"
                                            fill="currentColor"></path>
                                        <path d="M11.5 4a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" fill="currentColor"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Members') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                           <!-- Liability -->
                 <li>
                    <a href="{{ route(auth()->user()->roleName . 'liability.index') }}"
                        class="{{ request()->is('*liability/index*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-1 rounded">
                        <div class="pr-2">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor">
                                <title>money</title>
                                <path d="M59.16,11.18H12.83a5.39,5.39,0,0,0-5.22,5.56V39.18a6.77,6.77,0,0,0,1.88,4.38,5.54,5.54,0,0,0,3.34,1.26H59.16a5.47,5.47,0,0,0,5.23-5.64V16.74A5.4,5.4,0,0,0,59.16,11.18Zm1.34,21.7a12.27,12.27,0,0,0-7,7.74h-35a13,13,0,0,0-7-7.66V23A11.59,11.59,0,0,0,16,19.79a13,13,0,0,0,2.53-4.48h35a11.52,11.52,0,0,0,7,7.76v9.81Z"></path>
                                <path d="M36,18c-5.09,0-9.21,4.45-9.21,9.94s4.12,9.93,9.21,9.93,9.21-4.45,9.21-9.93S41,18,36,18Zm.75,15.62v1.86H35.09V33.79a6.25,6.25,0,0,1-2.9-.79l.5-2.14a5.68,5.68,0,0,0,2.82.8c1,0,1.63-.4,1.63-1.13s-.54-1.14-1.8-1.6c-1.82-.66-3.06-1.58-3.06-3.36a3.31,3.31,0,0,1,2.88-3.27V20.55h1.68v1.63a5.82,5.82,0,0,1,2.45.6l-.49,2.08a5.26,5.26,0,0,0-2.46-.63c-1.1,0-1.46.51-1.46,1s.59,1,2,1.58c2,.77,2.83,1.78,2.83,3.43A3.43,3.43,0,0,1,36.71,33.66Z"></path>
                            </svg>
                        </div>
                        <div>{{ __('Liabilities') }} </div>
                    </a>
                </li> 
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}"
                                class="{{ request()->is('*/trainers*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-1">
                                    <svg class="w-5 h-5" width="24" height="24" stroke-width="1.5"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.4 7H4.6C4.26863 7 4 7.26863 4 7.6V16.4C4 16.7314 4.26863 17 4.6 17H7.4C7.73137 17 8 16.7314 8 16.4V7.6C8 7.26863 7.73137 7 7.4 7Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M19.4 7H16.6C16.2686 7 16 7.26863 16 7.6V16.4C16 16.7314 16.2686 17 16.6 17H19.4C19.7314 17 20 16.7314 20 16.4V7.6C20 7.26863 19.7314 7 19.4 7Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M1 14.4V9.6C1 9.26863 1.26863 9 1.6 9H3.4C3.73137 9 4 9.26863 4 9.6V14.4C4 14.7314 3.73137 15 3.4 15H1.6C1.26863 15 1 14.7314 1 14.4Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path
                                            d="M23 14.4V9.6C23 9.26863 22.7314 9 22.4 9H20.6C20.2686 9 20 9.26863 20 9.6V14.4C20 14.7314 20.2686 15 20.6 15H22.4C22.7314 15 23 14.7314 23 14.4Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M8 12H16" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Trainers') }} </div>
                            </a>
                        </li>

                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}"
                                class="{{ request()->is('*leads*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Leads') }} </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'deleted.member.index') }}"
                                class="{{ request()->is('*deleted-members*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Deleted Members') }} </div>
                            </a>
                        </li>
                        {{-- staff --}}
                        @can('isAdmin')
                            <li>
                                <a href="{{ route(auth()->user()->roleName . 'staff.index') }}"
                                    class="{{ request()->is('*staffs*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }}  flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                    <div class="pr-2">
                                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            id="mdi-human-male-board-poll" viewBox="0 0 24 24">
                                            <path
                                                d="M20 17C21.1 17 22 16.1 22 15V4C22 2.9 21.1 2 20 2H9.5C9.8 2.6 10 3.3 10 4H20V15H11V17M15 7V9H9V22H7V16H5V22H3V14H1.5V9C1.5 7.9 2.4 7 3.5 7H15M8 4C8 5.1 7.1 6 6 6S4 5.1 4 4 4.9 2 6 2 8 2.9 8 4M17 6H19V14H17V6M14 10H16V14H14V10M11 10H13V14H11V10Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>{{ __('Staff') }} </div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
              
                 <!-- Unified Search -->
                 {{-- <li>
                    <a href="{{ route(auth()->user()->roleName . 'unified.search') }}"
                        class="{{ request()->is('*unified-search*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-1 rounded">
                        <div class="pr-2">
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4v2h16V4zm0 4H4v2h16V8zm-8 4H4v2h8v-2zm8 0h-6v6h6v2h2v-2h-2v-6zm-4 4v-2h2v2h-2zm-4 0H4v2h8v-2z" fill="currentColor"></path></svg>
                        </div>
                        <div>{{ __('Unified Search') }} </div>
                    </a>
                </li> --}}
                {{-- personal trainer --}}
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'pt.index') }}"
                        class="{{ request()->is('*personal_training*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center gap-2 w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <div>
                            <svg class="w-6 h-6" width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.4 7H4.6C4.26863 7 4 7.26863 4 7.6V16.4C4 16.7314 4.26863 17 4.6 17H7.4C7.73137 17 8 16.7314 8 16.4V7.6C8 7.26863 7.73137 7 7.4 7Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M19.4 7H16.6C16.2686 7 16 7.26863 16 7.6V16.4C16 16.7314 16.2686 17 16.6 17H19.4C19.7314 17 20 16.7314 20 16.4V7.6C20 7.26863 19.7314 7 19.4 7Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M1 14.4V9.6C1 9.26863 1.26863 9 1.6 9H3.4C3.73137 9 4 9.26863 4 9.6V14.4C4 14.7314 3.73137 15 3.4 15H1.6C1.26863 15 1 14.7314 1 14.4Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M23 14.4V9.6C23 9.26863 22.7314 9 22.4 9H20.6C20.2686 9 20 9.26863 20 9.6V14.4C20 14.7314 20.2686 15 20.6 15H22.4C22.7314 15 23 14.7314 23 14.4Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M8 12H16" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </div>
                        <div>{{ __('Manage PT') }} </div>
                    </a>
                </li>
                @can('isAdmin')
                    {{-- Branch --}}
                    <li>
                        <a href="{{ route(auth()->user()->roleName . 'branch.index') }}"
                            class="{{ request()->is('*branches*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                            <div class="pr-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <g>
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M2 18h7v2H2v-2zm0-7h9v2H2v-2zm0-7h20v2H2V4zm18.674 9.025l1.156-.391 1 1.732-.916.805a4.017 4.017 0 0 1 0 1.658l.916.805-1 1.732-1.156-.391c-.41.37-.898.655-1.435.83L19 21h-2l-.24-1.196a3.996 3.996 0 0 1-1.434-.83l-1.156.392-1-1.732.916-.805a4.017 4.017 0 0 1 0-1.658l-.916-.805 1-1.732 1.156.391c.41-.37.898-.655 1.435-.83L17 11h2l.24 1.196c.536.174 1.024.46 1.434.83zM18 17a1 1 0 1 0 0-2 1 1 0 0 0 0 2z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div>{{ __('Branches') }} </div>
                        </a>
                    </li>
                @endcan
                @can('isAdmin')
                    {{-- Membership Plans --}}
                    <li>
                        <a href="{{ route(auth()->user()->roleName . 'membershipplan.index') }}"
                            class="{{ request()->is('*/plans*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                            <div class="pr-2">
                                <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                                    <path
                                        d="M610.5 341.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 368.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm224 32c1.9 0 3.7-.5 5.6-.6 8.3-21.7 20.5-42.1 36.3-59.2 7.4-8 17.9-12.6 28.9-12.6 6.9 0 13.7 1.8 19.6 5.3l7.9 4.6c.8-.5 1.6-.9 2.4-1.4 7-14.6 11.2-30.8 11.2-48 0-61.9-50.1-112-112-112S208 82.1 208 144c0 61.9 50.1 112 112 112zm105.2 194.5c-2.3-1.2-4.6-2.6-6.8-3.9-8.2 4.8-15.3 9.8-27.5 9.8-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-10.7-34.5 24.9-49.7 25.8-50.3-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-3.8-2.2-7-5-9.8-8.1-3.3.2-6.5.6-9.8.6-24.6 0-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h255.4c-3.7-6-6.2-12.8-6.2-20.3v-9.2zM173.1 274.6C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z">
                                    </path>
                                </svg>
                            </div>
                            <div>{{ __('Plans') }} </div>
                        </a>
                    </li>
                @endcan
                <li>
                    <button @click="open = (open == 'reports' ? null : 'reports')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                fill="currentColor">
                                <defs></defs>
                                <title>report--alt</title>
                                <rect x="10" y="18" width="8" height="2"></rect>
                                <rect x="10" y="13" width="12" height="2"></rect>
                                <rect x="10" y="23" width="5" height="2"></rect>
                                <path
                                    d="M25,5H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2H25a2,2,0,0,0,2-2V7A2,2,0,0,0,25,5ZM12,4h8V8H12ZM25,28H7V7h3v3H22V7h3Z">
                                </path>
                                <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1"
                                    width="32" height="32" style="fill:none"></rect>
                            </svg>
                            {{ __('Reports') }}
                        </span>
                        <span x-show="open == 'reports'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'reports'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'reports'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.index') }}"
                                class="{{ request()->is('*upcoming-renewal*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.00008 10C9.00008 10.5523 8.55236 11 8.00008 11 7.44779 11 7.00008 10.5523 7.00008 10 7.00008 9.44772 7.44779 9 8.00008 9 8.55236 9 9.00008 9.44772 9.00008 10ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM11.0001 10C11.0001 11.6569 9.65693 13 8.00008 13 6.34322 13 5.00008 11.6569 5.00008 10 5.00008 8.34315 6.34322 7 8.00008 7 9.65693 7 11.0001 8.34315 11.0001 10ZM5.52725 17.0251 4.11304 15.6109C5.10725 14.6167 6.48362 14 8.00212 14 9.52063 14 10.897 14.6167 11.8912 15.6109L10.477 17.0251C9.84253 16.3907 8.9689 16 8.00212 16 7.03535 16 6.16172 16.3907 5.52725 17.0251ZM16.0001 10.5858 17.793 8.79289 19.2072 10.2071 17.4143 12 19.2072 13.7929 17.793 15.2071 16.0001 13.4142 14.2072 15.2071 12.793 13.7929 14.5859 12 12.793 10.2071 14.2072 8.79289 16.0001 10.5858Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Upcoming Renewal') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'expired.plan.index') }}"
                                class="{{ request()->is('*expired-plan*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="48" height="48" fill="white" fill-opacity="0.01">
                                        </rect>
                                        <path d="M6 5V30.0036H42V5" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M30 37L24 43L18 37" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M24 30V43" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M18.3438 20.6579L29.6575 9.34424" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M18.3438 9.34315L29.6575 20.6569" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Expired Plan') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'transaction.report.index') }}"
                                class="{{ request()->is('*transactions/report*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Transaction Report') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'remaining.balance.index') }}"
                                class="{{ request()->is('*remaining-balance*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.00008 10C9.00008 10.5523 8.55236 11 8.00008 11 7.44779 11 7.00008 10.5523 7.00008 10 7.00008 9.44772 7.44779 9 8.00008 9 8.55236 9 9.00008 9.44772 9.00008 10ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM11.0001 10C11.0001 11.6569 9.65693 13 8.00008 13 6.34322 13 5.00008 11.6569 5.00008 10 5.00008 8.34315 6.34322 7 8.00008 7 9.65693 7 11.0001 8.34315 11.0001 10ZM5.52725 17.0251 4.11304 15.6109C5.10725 14.6167 6.48362 14 8.00212 14 9.52063 14 10.897 14.6167 11.8912 15.6109L10.477 17.0251C9.84253 16.3907 8.9689 16 8.00212 16 7.03535 16 6.16172 16.3907 5.52725 17.0251ZM16.0001 10.5858 17.793 8.79289 19.2072 10.2071 17.4143 12 19.2072 13.7929 17.793 15.2071 16.0001 13.4142 14.2072 15.2071 12.793 13.7929 14.5859 12 12.793 10.2071 14.2072 8.79289 16.0001 10.5858Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Remaining Balance') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'followup.lead.index') }}"
                                class="{{ request()->is('*follow-up-lead*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                                    </svg>
                                </div>
                                <div>{{ __('Follow Up Lead') }} </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button @click="open = (open == 'workouts' ? null : 'workouts')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                            {{ __('Workouts') }}
                        </span>
                        <span x-show="open == 'workouts'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'workouts'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'workouts'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}"
                                class="{{ request()->is('*workout-plans*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M18,4 L18,0 L18,4 Z M7,18 L5,18 L7,18 Z M19,18 L9,18 L19,18 Z M7,14 L5,14 L7,14 Z M19,14 L9,14 L19,14 Z M6,4 L6,0 L6,4 Z M1,9 L23,9 L1,9 Z M1,23 L23,23 L23,4 L1,4 L1,23 Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Plans') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}"
                                class="{{ request()->is('*workout-categories*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                        fill="currentColor">
                                        <defs></defs>
                                        <title>collapse-categories</title>
                                        <rect x="14" y="25" width="14" height="2"></rect>
                                        <polygon points="7.17 26 4.59 28.58 6 30 10 26 6 22 4.58 23.41 7.17 26">
                                        </polygon>
                                        <rect x="14" y="15" width="14" height="2"></rect>
                                        <polygon points="7.17 16 4.59 18.58 6 20 10 16 6 12 4.58 13.41 7.17 16">
                                        </polygon>
                                        <rect x="14" y="5" width="14" height="2"></rect>
                                        <polygon points="7.17 6 4.59 8.58 6 10 10 6 6 2 4.58 3.41 7.17 6"></polygon>
                                        <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>"
                                            class="cls-1" width="32" height="32" style="fill:none"></rect>
                                    </svg>
                                </div>
                                <div>{{ __('Categories') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'exercises.index') }}"
                                class="{{ request()->is('*exercises*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-5 h-5" width="48" height="48" viewBox="0 0 48 48"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.4 36.2C35.8418 35.8687 36.4686 35.9582 36.8 36.4L39.5 39.9998H41C41.5523 39.9998 42 40.4476 42 40.9998C42 41.5521 41.5523 41.9998 41 41.9998H36C35.4477 41.9998 35 41.5521 35 40.9998C35 40.4476 35.4477 39.9998 36 39.9998H36.9999L35.2 37.6C34.8686 37.1582 34.9582 36.5314 35.4 36.2Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M33 38C37.9706 38 42 33.9706 42 29C42 24.0295 37.9706 20 33 20C29.8795 20 27.1299 21.5882 25.5154 24.0003L32.5766 24.0001C35.5718 24.0001 38 26.4282 38 29.4234C38 31.8678 36.3647 34.0102 34.0068 34.6547L27.8049 36.3501C29.2724 37.3893 31.0649 38 33 38ZM26.0755 34.7495L33.4794 32.7255C34.9678 32.3187 36 30.9664 36 29.4234C36 27.5328 34.4673 26.0001 32.5766 26.0001L24.512 26.0003C24.1804 26.9386 24 27.9482 24 29C24 31.1861 24.7794 33.1902 26.0755 34.7495Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M30.569 37.6679C29.5659 37.3871 28.6336 36.9369 27.8049 36.3501L34.0068 34.6547C36.3647 34.0102 38 31.8678 38 29.4234C38 26.4282 35.5718 24.0001 32.5766 24.0001L25.5154 24.0003C26.0209 23.245 26.6377 22.5705 27.3424 22.0002C28.8882 20.7493 30.8566 20 33 20C37.9706 20 42 24.0295 42 29C42 33.9706 37.9706 38 33 38C32.1576 38 31.3423 37.8843 30.569 37.6679ZM39.997 29.2086C39.999 29.1393 40 29.0698 40 29C40 25.134 36.866 22 33 22C32.9297 22 32.8596 22.0011 32.7897 22.0031C36.7196 22.1139 39.8853 25.2789 39.997 29.2086ZM26.0755 34.7495L33.4794 32.7255C34.9678 32.3187 36 30.9664 36 29.4234C36 27.5328 34.4673 26.0001 32.5766 26.0001L24.512 26.0003C24.1804 26.9386 24 27.9482 24 29C24 31.1861 24.7794 33.1902 26.0755 34.7495ZM26.0706 28.0003C26.0241 28.3262 26 28.6599 26 29C26 30.2555 26.3291 31.4313 26.9067 32.4489L32.952 30.7963C33.5708 30.6272 34 30.0649 34 29.4234C34 28.6373 33.3628 28.0001 32.5767 28.0001L26.0706 28.0003Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.6 36.2C14.0418 36.5314 14.1314 37.1582 13.8 37.6L10.8 41.6C10.4686 42.0419 9.84183 42.1314 9.4 41.8C8.95817 41.4687 8.86863 40.8419 9.2 40.4L12.2 36.4C12.5314 35.9582 13.1582 35.8687 13.6 36.2Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M7 41C7 40.4477 7.44772 40 8 40H13C13.5523 40 14 40.4477 14 41C14 41.5523 13.5523 42 13 42H8C7.44772 42 7 41.5523 7 41Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 40C7.44772 40 7 40.4477 7 41C7 41.5523 7.44772 42 8 42H13C13.5523 42 14 41.5523 14 41C14 40.4477 13.5523 40 13 40H8Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 32.0196C8 28.6951 10.6951 26 14.0196 26H32.5798C34.4687 26 36 27.5313 36 29.4202C36 30.9472 34.9877 32.2893 33.5194 32.7088L15.6733 37.8076C11.8279 38.9063 8 36.0189 8 32.0196ZM15.7324 33C15.3866 33.5978 14.7403 34 14 34C12.8954 34 12 33.1046 12 32C12 30.8955 12.8954 30 14 30C14.7403 30 15.3866 30.4022 15.7324 31H19C19.5523 31 20 31.4477 20 32C20 32.5523 19.5523 33 19 33H15.7324Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10 32.0098C10 32.0131 10 32.0164 10 32.0196C10 34.6902 12.5561 36.6183 15.1239 35.8846L18.2199 35H16.6454C15.9414 35.6211 15.0155 36 14 36C11.7941 36 10.0053 34.2145 10 32.0098ZM14.0098 28C14.0131 28 14.0163 28 14.0196 28H32.5798C33.3642 28 34 28.6359 34 29.4202C34 30.0543 33.5797 30.6115 32.97 30.7857L21.0484 34.1919C21.634 33.6444 22 32.865 22 32C22 30.3432 20.6569 29 19 29H16.6454C15.9437 28.3809 15.0215 28.0025 14.0098 28ZM15.7324 33C15.3866 33.5978 14.7403 34 14 34C12.8954 34 12 33.1046 12 32C12 30.8955 12.8954 30 14 30C14.7403 30 15.3866 30.4022 15.7324 31H19C19.5523 31 20 31.4477 20 32C20 32.5523 19.5523 33 19 33H15.7324ZM14.0196 26C10.6951 26 8 28.6951 8 32.0196C8 36.0189 11.8279 38.9063 15.6733 37.8076L33.5194 32.7088C34.9877 32.2893 36 30.9472 36 29.4202C36 27.5313 34.4687 26 32.5798 26H14.0196Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.7017 18.0455C11.2289 17.8808 11.7897 18.1746 11.9545 18.7017L14.4545 26.7016C14.6192 27.2288 14.3254 27.7897 13.7983 27.9544C13.2711 28.1191 12.7103 27.8253 12.5455 27.2982L10.0455 19.2983C9.88079 18.7712 10.1746 18.2103 10.7017 18.0455Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.3431 6.06073C35.8619 6.25023 36.1288 6.82438 35.9393 7.34314L34.9393 10.0807C34.8409 10.3501 34.6317 10.5642 34.3647 10.6688L30.7771 12.0738L33.9383 20.6542C34.1293 21.1724 33.8639 21.7473 33.3457 21.9383C32.8275 22.1292 32.2526 21.8639 32.0617 21.3456L28.5617 11.8457C28.3735 11.3349 28.6284 10.7674 29.1353 10.5689L33.2154 8.97094L34.0607 6.65692C34.2502 6.13816 34.8244 5.87124 35.3431 6.06073Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M6 17.1497C6 15.4633 7.45602 14.1456 9.134 14.3134L13.6365 14.7637C14.9782 14.8979 16 16.0269 16 17.3753C16 18.8249 14.8249 20 13.3753 20H8.85037C7.27616 20 6 18.7239 6 17.1497Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.4375 16.7537L8.93499 16.3035C8.43439 16.2534 8 16.6466 8 17.1497C8 17.6193 8.38072 18 8.85037 18H13.3753C13.7203 18 14 17.7203 14 17.3753C14 17.0544 13.7568 16.7857 13.4375 16.7537ZM9.134 14.3134C7.45602 14.1456 6 15.4633 6 17.1497C6 18.7239 7.27616 20 8.85037 20H13.3753C14.8249 20 16 18.8249 16 17.3753C16 16.0269 14.9782 14.8979 13.6365 14.7637L9.134 14.3134Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Exercises') }} </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li>
                    <a href="{{ route(auth()->user()->roleName . 'sms.index') }}"
                        class="{{ request()->is('*SMS*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center gap-2 w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <div>
                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><path d="M2 5.25C2 3.45507 3.45507 2 5.25 2H15.75C17.5449 2 19 3.45507 19 5.25V10.0072C18.9173 10.0024 18.8339 10 18.75 10H17.5V5.25C17.5 4.2835 16.7165 3.5 15.75 3.5H5.25C4.2835 3.5 3.5 4.2835 3.5 5.25V16.75C3.5 17.7165 4.2835 18.5 5.25 18.5H6V18.75C6 19.185 6.06536 19.6048 6.1868 20H5.25C3.45508 20 2 18.5449 2 16.75V5.25ZM6.75 5C6.33579 5 6 5.33579 6 5.75C6 6.16421 6.33579 6.5 6.75 6.5H14.25C14.6642 6.5 15 6.16421 15 5.75C15 5.33579 14.6642 5 14.25 5H6.75ZM8 8.25C8 7.83579 8.33579 7.5 8.75 7.5H14.25C14.6642 7.5 15 7.83579 15 8.25C15 8.66421 14.6642 9 14.25 9H8.75C8.33579 9 8 8.66421 8 8.25ZM7 14.25C7 12.4551 8.45507 11 10.25 11H18.75C20.5449 11 22 12.4551 22 14.25V18.75C22 20.5449 20.5449 22 18.75 22H10.25C8.45507 22 7 20.5449 7 18.75V14.25ZM10.25 12.5C9.74571 12.5 9.29124 12.7133 8.9719 13.0546L14.5001 16.6084L20.0281 13.0546C19.7088 12.7133 19.2543 12.5 18.75 12.5H10.25ZM8.5 18.75C8.5 19.7165 9.2835 20.5 10.25 20.5H18.75C19.7165 20.5 20.5 19.7165 20.5 18.75V14.5345L14.9056 18.1309C14.6586 18.2897 14.3415 18.2897 14.0945 18.1309L8.5 14.5345V18.75Z" fill="currentColor"></path></svg>
                        </div>
                        <div>{{ __('Templates') }} </div>
                    </a>
                </li> -->
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'attendance.index') }}"
                        class="{{ request()->is('*attendance/index*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center gap-2 w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <div>
                        <svg class="w-6 h-6" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.9896 29.0025C33.3205 28.9646 31.2731 29.3354 27.378 30.9258L26.622 29.0742C30.7491 27.389 33.0599 26.9618 37.0103 27.0027L36.9896 29.0025Z" fill="currentColor"></path>
                        <path d="M27.378 26.9258C31.2731 25.3354 33.3205 24.9646 36.9896 25.0025L37.0103 23.0027C33.0599 22.9618 30.7491 23.389 26.622 25.0742L27.378 26.9258Z" fill="currentColor"></path>
                        <path d="M36.9896 21.0025C33.3205 20.9646 31.2731 21.3354 27.378 22.9258L26.622 21.0742C30.7491 19.389 33.0599 18.9618 37.0103 19.0027L36.9896 21.0025Z" fill="currentColor"></path>
                        <path d="M34.5 16V13H36.5V16H34.5Z" fill="currentColor"></path>
                        <path d="M31 14V17H33V14H31Z" fill="currentColor"></path>
                        <path d="M27.5 18V15H29.5V18H27.5Z" fill="currentColor"></path>
                        <path d="M11.0104 29.0025C14.6795 28.9646 16.7269 29.3354 20.622 30.9258L21.378 29.0742C17.2509 27.389 14.9401 26.9618 10.9896 27.0027L11.0104 29.0025Z" fill="currentColor"></path>
                        <path d="M20.622 26.9258C16.7269 25.3354 14.6795 24.9646 11.0104 25.0025L10.9896 23.0027C14.9401 22.9618 17.2509 23.389 21.378 25.0742L20.622 26.9258Z" fill="currentColor"></path>
                        <path d="M11.0104 21.0025C14.6795 20.9646 16.7269 21.3354 20.622 22.9258L21.378 21.0742C17.2509 19.389 14.9401 18.9618 10.9896 19.0027L11.0104 21.0025Z" fill="currentColor"></path>
                        <path d="M13.5 16V13H11.5V16H13.5Z" fill="currentColor"></path>
                        <path d="M17 14V17H15V14H17Z" fill="currentColor"></path>
                        <path d="M20.5 18V15H18.5V18H20.5Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M42 10.9838C42.4057 11.073 42.8198 11.1686 43.2434 11.2707C43.6888 11.378 44 11.7783 44 12.2365V37.7749C44 38.4077 43.4173 38.8804 42.7957 38.7618C36.5832 37.5766 32.3951 37.4936 26.6742 38.3611C26.1781 39.3339 25.1669 40 24 40C22.8331 40 21.8219 39.3339 21.3258 38.3611C15.6049 37.4936 11.4168 37.5766 5.20425 38.7618C4.58268 38.8804 4 38.4077 4 37.7749V12.2365C4 11.7783 4.31119 11.378 4.75659 11.2707C5.18022 11.1686 5.59433 11.073 6 10.9838V10.524C6 9.63895 6.589 8.83011 7.48401 8.60493C13.6344 7.0576 18.1123 8.69563 23.2406 11.0814C23.4904 11.1326 23.7435 11.1855 24 11.2401C24.2565 11.1855 24.5096 11.1326 24.7594 11.0814C29.8877 8.69563 34.3656 7.0576 40.516 8.60493C41.411 8.83011 42 9.63895 42 10.524V10.9838ZM40 33.9681L40 33.967V10.5375C34.3416 9.12233 30.3169 10.6723 25 13.1762V36.4187L25.0028 36.4209C25.0034 36.4213 25.0041 36.4217 25.0047 36.4221C25.009 36.4244 25.0125 36.4251 25.0139 36.4252L25.015 36.4252L25.0173 36.4246C25.0186 36.4242 25.0204 36.4236 25.0227 36.4225C29.9319 34.2006 34.2143 32.9404 39.9457 33.9865C39.9564 33.9884 39.9645 33.9877 39.9714 33.9859C39.9795 33.9838 39.9871 33.9798 39.9932 33.9749C39.997 33.9719 39.999 33.9694 40 33.9681ZM22.9972 36.4209L23 36.4189V13.1772C17.6831 10.6732 13.6584 9.12233 8 10.5375V33.967L8.00001 33.9681C8.00095 33.9694 8.003 33.9719 8.00678 33.9749C8.01286 33.9798 8.02054 33.9838 8.02856 33.9859C8.03554 33.9877 8.04358 33.9884 8.05429 33.9865C13.7857 32.9404 18.0681 34.2006 22.9773 36.4225C22.9823 36.4248 22.9847 36.4252 22.985 36.4252L22.9861 36.4252C22.9877 36.4251 22.9921 36.4242 22.9972 36.4209Z" fill="currentColor"></path>
                        </svg>
                        </div>
                        <div>{{ __('Attendance') }} </div>
                    </a>
                </li> 
            </ul>
        </nav>
    </section>

    <!-- Mobile menu, show/hide based on menu state. -->
    <section class="md:hidden fixed bg-slate-900 w-full mt-16 pb-8 z-50" id="mobile-menu" x-cloak
        x-show="mobilemenue" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95" @click.away="mobilemenue = false
       ">
        <!-- nav -->
        <!-- nav -->
        <nav class="px-4 w-full pt-2">
            <ul class="space-y-2">
                <!-- ITEM -->
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}"
                        class="{{ request()->is('*dashboard') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded">
                        <div class="pr-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>{{ __('Dashboard') }} </div>
                    </a>
                </li>
                <li>
                    <button @click="open = (open == 'users' ? null : 'users')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                </path>
                            </svg>
                            {{ __('Users') }}
                        </span>
                        <span x-show="open == 'users'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'users'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'users'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.index') }}"
                                class="{{ request()->is('*/members*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15"
                                        fill="currentColor">
                                        <path
                                            d="M5.5 0a3.499 3.499 0 100 6.996A3.499 3.499 0 105.5 0zm-2 8.994a3.5 3.5 0 00-3.5 3.5v2.497h11v-2.497a3.5 3.5 0 00-3.5-3.5h-4zm9 1.006H12v5h3v-2.5a2.5 2.5 0 00-2.5-2.5z"
                                            fill="currentColor"></path>
                                        <path d="M11.5 4a2.5 2.5 0 100 5 2.5 2.5 0 000-5z" fill="currentColor"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Members') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}"
                                class="{{ request()->is('*/trainers*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-1">
                                    <svg class="w-5 h-5" width="24" height="24" stroke-width="1.5"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.4 7H4.6C4.26863 7 4 7.26863 4 7.6V16.4C4 16.7314 4.26863 17 4.6 17H7.4C7.73137 17 8 16.7314 8 16.4V7.6C8 7.26863 7.73137 7 7.4 7Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M19.4 7H16.6C16.2686 7 16 7.26863 16 7.6V16.4C16 16.7314 16.2686 17 16.6 17H19.4C19.7314 17 20 16.7314 20 16.4V7.6C20 7.26863 19.7314 7 19.4 7Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M1 14.4V9.6C1 9.26863 1.26863 9 1.6 9H3.4C3.73137 9 4 9.26863 4 9.6V14.4C4 14.7314 3.73137 15 3.4 15H1.6C1.26863 15 1 14.7314 1 14.4Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                        <path
                                            d="M23 14.4V9.6C23 9.26863 22.7314 9 22.4 9H20.6C20.2686 9 20 9.26863 20 9.6V14.4C20 14.7314 20.2686 15 20.6 15H22.4C22.7314 15 23 14.7314 23 14.4Z"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        </path>
                                        <path d="M8 12H16" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Trainers') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}"
                                class="{{ request()->is('*leads*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Leads') }} </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'deleted.member.index') }}"
                                class="{{ request()->is('*deleted-members*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Deleted Members') }} </div>
                            </a>
                        </li>
                        {{-- staff --}}
                        @can('isAdmin')
                            <li>
                                <a href="{{ route(auth()->user()->roleName . 'staff.index') }}"
                                    class="{{ request()->is('*staffs*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }}  flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                                    <div class="pr-2">
                                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            id="mdi-human-male-board-poll" viewBox="0 0 24 24">
                                            <path
                                                d="M20 17C21.1 17 22 16.1 22 15V4C22 2.9 21.1 2 20 2H9.5C9.8 2.6 10 3.3 10 4H20V15H11V17M15 7V9H9V22H7V16H5V22H3V14H1.5V9C1.5 7.9 2.4 7 3.5 7H15M8 4C8 5.1 7.1 6 6 6S4 5.1 4 4 4.9 2 6 2 8 2.9 8 4M17 6H19V14H17V6M14 10H16V14H14V10M11 10H13V14H11V10Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>{{ __('Staff') }} </div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                {{-- personal trainer --}}
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'pt.index') }}"
                        class="{{ request()->is('*personal_training*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center gap-2 w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <div>
                            <svg class="w-6 h-6" width="24" height="24" stroke-width="1.5"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.4 7H4.6C4.26863 7 4 7.26863 4 7.6V16.4C4 16.7314 4.26863 17 4.6 17H7.4C7.73137 17 8 16.7314 8 16.4V7.6C8 7.26863 7.73137 7 7.4 7Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M19.4 7H16.6C16.2686 7 16 7.26863 16 7.6V16.4C16 16.7314 16.2686 17 16.6 17H19.4C19.7314 17 20 16.7314 20 16.4V7.6C20 7.26863 19.7314 7 19.4 7Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M1 14.4V9.6C1 9.26863 1.26863 9 1.6 9H3.4C3.73137 9 4 9.26863 4 9.6V14.4C4 14.7314 3.73137 15 3.4 15H1.6C1.26863 15 1 14.7314 1 14.4Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M23 14.4V9.6C23 9.26863 22.7314 9 22.4 9H20.6C20.2686 9 20 9.26863 20 9.6V14.4C20 14.7314 20.2686 15 20.6 15H22.4C22.7314 15 23 14.7314 23 14.4Z"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M8 12H16" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </div>
                        <div>{{ __('Manage PT') }} </div>
                    </a>
                </li>
                @can('isAdmin')
                    {{-- Branch --}}
                    <li>
                        <a href="{{ route(auth()->user()->roleName . 'branch.index') }}"
                            class="{{ request()->is('*branches*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500 ">
                            <div class="pr-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <g>
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M2 18h7v2H2v-2zm0-7h9v2H2v-2zm0-7h20v2H2V4zm18.674 9.025l1.156-.391 1 1.732-.916.805a4.017 4.017 0 0 1 0 1.658l.916.805-1 1.732-1.156-.391c-.41.37-.898.655-1.435.83L19 21h-2l-.24-1.196a3.996 3.996 0 0 1-1.434-.83l-1.156.392-1-1.732.916-.805a4.017 4.017 0 0 1 0-1.658l-.916-.805 1-1.732 1.156.391c.41-.37.898-.655 1.435-.83L17 11h2l.24 1.196c.536.174 1.024.46 1.434.83zM18 17a1 1 0 1 0 0-2 1 1 0 0 0 0 2z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            <div>{{ __('Branches') }} </div>
                        </a>
                    </li>
                @endcan
                @can('isAdmin')
                    {{-- Membership Plans --}}
                    <li>
                        <a href="{{ route(auth()->user()->roleName . 'membershipplan.index') }}"
                            class="{{ request()->is('*/plans*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                            <div class="pr-2">
                                <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                                    <path
                                        d="M610.5 341.3c2.6-14.1 2.6-28.5 0-42.6l25.8-14.9c3-1.7 4.3-5.2 3.3-8.5-6.7-21.6-18.2-41.2-33.2-57.4-2.3-2.5-6-3.1-9-1.4l-25.8 14.9c-10.9-9.3-23.4-16.5-36.9-21.3v-29.8c0-3.4-2.4-6.4-5.7-7.1-22.3-5-45-4.8-66.2 0-3.3.7-5.7 3.7-5.7 7.1v29.8c-13.5 4.8-26 12-36.9 21.3l-25.8-14.9c-2.9-1.7-6.7-1.1-9 1.4-15 16.2-26.5 35.8-33.2 57.4-1 3.3.4 6.8 3.3 8.5l25.8 14.9c-2.6 14.1-2.6 28.5 0 42.6l-25.8 14.9c-3 1.7-4.3 5.2-3.3 8.5 6.7 21.6 18.2 41.1 33.2 57.4 2.3 2.5 6 3.1 9 1.4l25.8-14.9c10.9 9.3 23.4 16.5 36.9 21.3v29.8c0 3.4 2.4 6.4 5.7 7.1 22.3 5 45 4.8 66.2 0 3.3-.7 5.7-3.7 5.7-7.1v-29.8c13.5-4.8 26-12 36.9-21.3l25.8 14.9c2.9 1.7 6.7 1.1 9-1.4 15-16.2 26.5-35.8 33.2-57.4 1-3.3-.4-6.8-3.3-8.5l-25.8-14.9zM496 368.5c-26.8 0-48.5-21.8-48.5-48.5s21.8-48.5 48.5-48.5 48.5 21.8 48.5 48.5-21.7 48.5-48.5 48.5zM96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm224 32c1.9 0 3.7-.5 5.6-.6 8.3-21.7 20.5-42.1 36.3-59.2 7.4-8 17.9-12.6 28.9-12.6 6.9 0 13.7 1.8 19.6 5.3l7.9 4.6c.8-.5 1.6-.9 2.4-1.4 7-14.6 11.2-30.8 11.2-48 0-61.9-50.1-112-112-112S208 82.1 208 144c0 61.9 50.1 112 112 112zm105.2 194.5c-2.3-1.2-4.6-2.6-6.8-3.9-8.2 4.8-15.3 9.8-27.5 9.8-10.9 0-21.4-4.6-28.9-12.6-18.3-19.8-32.3-43.9-40.2-69.6-10.7-34.5 24.9-49.7 25.8-50.3-.1-2.6-.1-5.2 0-7.8l-7.9-4.6c-3.8-2.2-7-5-9.8-8.1-3.3.2-6.5.6-9.8.6-24.6 0-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h255.4c-3.7-6-6.2-12.8-6.2-20.3v-9.2zM173.1 274.6C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z">
                                    </path>
                                </svg>
                            </div>
                            <div>{{ __('Plans') }} </div>
                        </a>
                    </li>
                @endcan
                <li>
                    <button @click="open = (open == 'reports' ? null : 'reports')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                fill="currentColor">
                                <defs></defs>
                                <title>report--alt</title>
                                <rect x="10" y="18" width="8" height="2"></rect>
                                <rect x="10" y="13" width="12" height="2"></rect>
                                <rect x="10" y="23" width="5" height="2"></rect>
                                <path
                                    d="M25,5H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2H25a2,2,0,0,0,2-2V7A2,2,0,0,0,25,5ZM12,4h8V8H12ZM25,28H7V7h3v3H22V7h3Z">
                                </path>
                                <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>" class="cls-1"
                                    width="32" height="32" style="fill:none"></rect>
                            </svg>
                            {{ __('Reports') }}
                        </span>
                        <span x-show="open == 'reports'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'reports'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'reports'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.index') }}"
                                class="{{ request()->is('*upcoming-renewal*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.00008 10C9.00008 10.5523 8.55236 11 8.00008 11 7.44779 11 7.00008 10.5523 7.00008 10 7.00008 9.44772 7.44779 9 8.00008 9 8.55236 9 9.00008 9.44772 9.00008 10ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM11.0001 10C11.0001 11.6569 9.65693 13 8.00008 13 6.34322 13 5.00008 11.6569 5.00008 10 5.00008 8.34315 6.34322 7 8.00008 7 9.65693 7 11.0001 8.34315 11.0001 10ZM5.52725 17.0251 4.11304 15.6109C5.10725 14.6167 6.48362 14 8.00212 14 9.52063 14 10.897 14.6167 11.8912 15.6109L10.477 17.0251C9.84253 16.3907 8.9689 16 8.00212 16 7.03535 16 6.16172 16.3907 5.52725 17.0251ZM16.0001 10.5858 17.793 8.79289 19.2072 10.2071 17.4143 12 19.2072 13.7929 17.793 15.2071 16.0001 13.4142 14.2072 15.2071 12.793 13.7929 14.5859 12 12.793 10.2071 14.2072 8.79289 16.0001 10.5858Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Upcoming Renewal') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'expired.plan.index') }}"
                                class="{{ request()->is('*expired-plan*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 48 48" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect width="48" height="48" fill="white" fill-opacity="0.01">
                                        </rect>
                                        <path d="M6 5V30.0036H42V5" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M30 37L24 43L18 37" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M24 30V43" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M18.3438 20.6579L29.6575 9.34424" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M18.3438 9.34315L29.6575 20.6569" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Expired Plan') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'transaction.report.index') }}"
                                class="{{ request()->is('*transactions/report*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Transaction Report') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'remaining.balance.index') }}"
                                class="{{ request()->is('*remaining-balance*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.00008 10C9.00008 10.5523 8.55236 11 8.00008 11 7.44779 11 7.00008 10.5523 7.00008 10 7.00008 9.44772 7.44779 9 8.00008 9 8.55236 9 9.00008 9.44772 9.00008 10ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM11.0001 10C11.0001 11.6569 9.65693 13 8.00008 13 6.34322 13 5.00008 11.6569 5.00008 10 5.00008 8.34315 6.34322 7 8.00008 7 9.65693 7 11.0001 8.34315 11.0001 10ZM5.52725 17.0251 4.11304 15.6109C5.10725 14.6167 6.48362 14 8.00212 14 9.52063 14 10.897 14.6167 11.8912 15.6109L10.477 17.0251C9.84253 16.3907 8.9689 16 8.00212 16 7.03535 16 6.16172 16.3907 5.52725 17.0251ZM16.0001 10.5858 17.793 8.79289 19.2072 10.2071 17.4143 12 19.2072 13.7929 17.793 15.2071 16.0001 13.4142 14.2072 15.2071 12.793 13.7929 14.5859 12 12.793 10.2071 14.2072 8.79289 16.0001 10.5858Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Remaining Balance') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'followup.lead.index') }}"
                                class="{{ request()->is('*follow-up-lead*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                                    </svg>
                                </div>
                                <div>{{ __('Follow Up Lead') }} </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button @click="open = (open == 'workouts' ? null : 'workouts')"
                        class="flex text-black items-center justify-between w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                        <span class="flex items-center gap-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                            {{ __('Workouts') }}
                        </span>
                        <span x-show="open == 'workouts'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                </path>
                            </svg>
                        </span>
                        <span x-show="open != 'workouts'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <ul class="space-y-1 mt-1 bg-gray-700 rounded-md p-1" x-show="open == 'workouts'" x-cloak>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'workout.plans.index') }}"
                                class="{{ request()->is('*workout-plans*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M18,4 L18,0 L18,4 Z M7,18 L5,18 L7,18 Z M19,18 L9,18 L19,18 Z M7,14 L5,14 L7,14 Z M19,14 L9,14 L19,14 Z M6,4 L6,0 L6,4 Z M1,9 L23,9 L1,9 Z M1,23 L23,23 L23,4 L1,4 L1,23 Z">
                                        </path>
                                    </svg>
                                </div>
                                <div>{{ __('Plans') }} </div>
                            </a>
                        </li>
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}"
                                class="{{ request()->is('*workout-categories*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                        fill="currentColor">
                                        <defs></defs>
                                        <title>collapse-categories</title>
                                        <rect x="14" y="25" width="14" height="2"></rect>
                                        <polygon points="7.17 26 4.59 28.58 6 30 10 26 6 22 4.58 23.41 7.17 26">
                                        </polygon>
                                        <rect x="14" y="15" width="14" height="2"></rect>
                                        <polygon points="7.17 16 4.59 18.58 6 20 10 16 6 12 4.58 13.41 7.17 16">
                                        </polygon>
                                        <rect x="14" y="5" width="14" height="2"></rect>
                                        <polygon points="7.17 6 4.59 8.58 6 10 10 6 6 2 4.58 3.41 7.17 6"></polygon>
                                        <rect id="_Transparent_Rectangle_" data-name="<Transparent Rectangle>"
                                            class="cls-1" width="32" height="32" style="fill:none"></rect>
                                    </svg>
                                </div>
                                <div>{{ __('Categories') }} </div>
                            </a>
                        </li>
                        
                        <!-- ITEM -->
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'exercises.index') }}"
                                class="{{ request()->is('*exercises*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex text-black items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500">
                                <div class="pr-2">
                                    <svg class="w-5 h-5" width="48" height="48" viewBox="0 0 48 48"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.4 36.2C35.8418 35.8687 36.4686 35.9582 36.8 36.4L39.5 39.9998H41C41.5523 39.9998 42 40.4476 42 40.9998C42 41.5521 41.5523 41.9998 41 41.9998H36C35.4477 41.9998 35 41.5521 35 40.9998C35 40.4476 35.4477 39.9998 36 39.9998H36.9999L35.2 37.6C34.8686 37.1582 34.9582 36.5314 35.4 36.2Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M33 38C37.9706 38 42 33.9706 42 29C42 24.0295 37.9706 20 33 20C29.8795 20 27.1299 21.5882 25.5154 24.0003L32.5766 24.0001C35.5718 24.0001 38 26.4282 38 29.4234C38 31.8678 36.3647 34.0102 34.0068 34.6547L27.8049 36.3501C29.2724 37.3893 31.0649 38 33 38ZM26.0755 34.7495L33.4794 32.7255C34.9678 32.3187 36 30.9664 36 29.4234C36 27.5328 34.4673 26.0001 32.5766 26.0001L24.512 26.0003C24.1804 26.9386 24 27.9482 24 29C24 31.1861 24.7794 33.1902 26.0755 34.7495Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M30.569 37.6679C29.5659 37.3871 28.6336 36.9369 27.8049 36.3501L34.0068 34.6547C36.3647 34.0102 38 31.8678 38 29.4234C38 26.4282 35.5718 24.0001 32.5766 24.0001L25.5154 24.0003C26.0209 23.245 26.6377 22.5705 27.3424 22.0002C28.8882 20.7493 30.8566 20 33 20C37.9706 20 42 24.0295 42 29C42 33.9706 37.9706 38 33 38C32.1576 38 31.3423 37.8843 30.569 37.6679ZM39.997 29.2086C39.999 29.1393 40 29.0698 40 29C40 25.134 36.866 22 33 22C32.9297 22 32.8596 22.0011 32.7897 22.0031C36.7196 22.1139 39.8853 25.2789 39.997 29.2086ZM26.0755 34.7495L33.4794 32.7255C34.9678 32.3187 36 30.9664 36 29.4234C36 27.5328 34.4673 26.0001 32.5766 26.0001L24.512 26.0003C24.1804 26.9386 24 27.9482 24 29C24 31.1861 24.7794 33.1902 26.0755 34.7495ZM26.0706 28.0003C26.0241 28.3262 26 28.6599 26 29C26 30.2555 26.3291 31.4313 26.9067 32.4489L32.952 30.7963C33.5708 30.6272 34 30.0649 34 29.4234C34 28.6373 33.3628 28.0001 32.5767 28.0001L26.0706 28.0003Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.6 36.2C14.0418 36.5314 14.1314 37.1582 13.8 37.6L10.8 41.6C10.4686 42.0419 9.84183 42.1314 9.4 41.8C8.95817 41.4687 8.86863 40.8419 9.2 40.4L12.2 36.4C12.5314 35.9582 13.1582 35.8687 13.6 36.2Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M7 41C7 40.4477 7.44772 40 8 40H13C13.5523 40 14 40.4477 14 41C14 41.5523 13.5523 42 13 42H8C7.44772 42 7 41.5523 7 41Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 40C7.44772 40 7 40.4477 7 41C7 41.5523 7.44772 42 8 42H13C13.5523 42 14 41.5523 14 41C14 40.4477 13.5523 40 13 40H8Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M8 32.0196C8 28.6951 10.6951 26 14.0196 26H32.5798C34.4687 26 36 27.5313 36 29.4202C36 30.9472 34.9877 32.2893 33.5194 32.7088L15.6733 37.8076C11.8279 38.9063 8 36.0189 8 32.0196ZM15.7324 33C15.3866 33.5978 14.7403 34 14 34C12.8954 34 12 33.1046 12 32C12 30.8955 12.8954 30 14 30C14.7403 30 15.3866 30.4022 15.7324 31H19C19.5523 31 20 31.4477 20 32C20 32.5523 19.5523 33 19 33H15.7324Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10 32.0098C10 32.0131 10 32.0164 10 32.0196C10 34.6902 12.5561 36.6183 15.1239 35.8846L18.2199 35H16.6454C15.9414 35.6211 15.0155 36 14 36C11.7941 36 10.0053 34.2145 10 32.0098ZM14.0098 28C14.0131 28 14.0163 28 14.0196 28H32.5798C33.3642 28 34 28.6359 34 29.4202C34 30.0543 33.5797 30.6115 32.97 30.7857L21.0484 34.1919C21.634 33.6444 22 32.865 22 32C22 30.3432 20.6569 29 19 29H16.6454C15.9437 28.3809 15.0215 28.0025 14.0098 28ZM15.7324 33C15.3866 33.5978 14.7403 34 14 34C12.8954 34 12 33.1046 12 32C12 30.8955 12.8954 30 14 30C14.7403 30 15.3866 30.4022 15.7324 31H19C19.5523 31 20 31.4477 20 32C20 32.5523 19.5523 33 19 33H15.7324ZM14.0196 26C10.6951 26 8 28.6951 8 32.0196C8 36.0189 11.8279 38.9063 15.6733 37.8076L33.5194 32.7088C34.9877 32.2893 36 30.9472 36 29.4202C36 27.5313 34.4687 26 32.5798 26H14.0196Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.7017 18.0455C11.2289 17.8808 11.7897 18.1746 11.9545 18.7017L14.4545 26.7016C14.6192 27.2288 14.3254 27.7897 13.7983 27.9544C13.2711 28.1191 12.7103 27.8253 12.5455 27.2982L10.0455 19.2983C9.88079 18.7712 10.1746 18.2103 10.7017 18.0455Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M35.3431 6.06073C35.8619 6.25023 36.1288 6.82438 35.9393 7.34314L34.9393 10.0807C34.8409 10.3501 34.6317 10.5642 34.3647 10.6688L30.7771 12.0738L33.9383 20.6542C34.1293 21.1724 33.8639 21.7473 33.3457 21.9383C32.8275 22.1292 32.2526 21.8639 32.0617 21.3456L28.5617 11.8457C28.3735 11.3349 28.6284 10.7674 29.1353 10.5689L33.2154 8.97094L34.0607 6.65692C34.2502 6.13816 34.8244 5.87124 35.3431 6.06073Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M6 17.1497C6 15.4633 7.45602 14.1456 9.134 14.3134L13.6365 14.7637C14.9782 14.8979 16 16.0269 16 17.3753C16 18.8249 14.8249 20 13.3753 20H8.85037C7.27616 20 6 18.7239 6 17.1497Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.4375 16.7537L8.93499 16.3035C8.43439 16.2534 8 16.6466 8 17.1497C8 17.6193 8.38072 18 8.85037 18H13.3753C13.7203 18 14 17.7203 14 17.3753C14 17.0544 13.7568 16.7857 13.4375 16.7537ZM9.134 14.3134C7.45602 14.1456 6 15.4633 6 17.1497C6 18.7239 7.27616 20 8.85037 20H13.3753C14.8249 20 16 18.8249 16 17.3753C16 16.0269 14.9782 14.8979 13.6365 14.7637L9.134 14.3134Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>
                                <div>{{ __('Exercises') }} </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route(auth()->user()->roleName . 'profile.edit') }}"
                        class="{{ request()->is('*profile*') ? ' text-white bg-orange-500' : 'hover:text-white hover:bg-orange-500' }} flex gap-2 text-white items-center w-full py-1.5 px-2 rounded hover:text-white hover:bg-orange-500"
                        role="menuitem" tabindex="-1" id="user-menu-item-0">
                        <svg class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16 9C16 11.2091 14.2091 13 12 13C9.79086 13 8 11.2091 8 9C8 6.79086 9.79086 5 12 5C14.2091 5 16 6.79086 16 9ZM14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z"
                                fill="currentColor"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1ZM3 12C3 14.0902 3.71255 16.014 4.90798 17.5417C6.55245 15.3889 9.14627 14 12.0645 14C14.9448 14 17.5092 15.3531 19.1565 17.4583C20.313 15.9443 21 14.0524 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12ZM12 21C9.84977 21 7.87565 20.2459 6.32767 18.9878C7.59352 17.1812 9.69106 16 12.0645 16C14.4084 16 16.4833 17.1521 17.7538 18.9209C16.1939 20.2191 14.1881 21 12 21Z"
                                fill="currentColor"></path>
                        </svg>
                        <span>
                            {{ __('My Profile') }}
                        </span>
                    </a>
                </li>
                <li>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            class="flex gap-2 text-white items-center w-full py-1.5 !px-2 rounded hover:text-white hover:bg-orange-500"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2">
                                </path>
                                <path d="M9 12h12l-3 -3"></path>
                                <path d="M18 15l3 -3"></path>
                            </svg>
                            <span>
                                {{ __('Log Out') }}
                            </span>
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </nav>
    </section>
    <script>
        function sidebar() {
            return {
                mobilemenue: false,
                open: null,
                activeDropdown() {
                    if (@js(request()->is('*members*')) || @js(request()->is('*leads*')) || @js(request()->is('*staffs*')) || @js(request()->is('*trainers*')) || @js(request()->is('*liability/index*'))) {
                        return 'users';
                    } else if (@js(request()->is('*upcoming-renewal*')) || @js(request()->is('*expired-plan*')) || @js(request()->is('*transactions/report*')) || @js(request()->is('*remaining-balance*')) ||
                        @js(request()->is('*follow-up-lead*'))) {
                        return 'reports';
                    } else if (@js(request()->is('*workout-plans*')) || @js(request()->is('*workout-categories*')) || @js(request()->is('*exercises*'))) {
                        return 'workouts';
                    } else {
                        return null;
                    }
                },
                init() {
                    this.open = this.activeDropdown();
                },
            }
        }
    </script>
</section>
