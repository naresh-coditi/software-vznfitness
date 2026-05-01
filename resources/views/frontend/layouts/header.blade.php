<header class="bg-gray-950">
    <div x-data="{ open: false }">
        <nav class="mx-auto flex items-center justify-between p-2 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="{{ route('login') }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <x-website-logo />
                </a>
            </div>
            <div class="flex lg:hidden" x-on:click="open = ! open">
                <button type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="{{ route('cancellation.and.refund.policy') }}"
                    class="text-lg font-semibold leading-6 text-gray-300 hover:text-amber-600 transition-colors">
                    {{ __('Cancellation/Refund Policy') }}
                </a>
                <a href="{{ route('privacy.and.policy') }}" class="text-lg font-semibold leading-6 text-gray-300 hover:text-amber-600 transition-colors">
                    {{ __('Privacy Policy') }}
                </a>
                <a href="{{ route('terms.and.conditions') }}" class="text-lg font-semibold leading-6 text-gray-300 hover:text-amber-600 transition-colors">
                    {{ __('Terms & Conditions') }}
                </a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-5">
                <a href="{{ route('login') }}" class="text-xl font-semibold leading-6 text-white hover:text-amber-600 transition-colors flex items-center gap-2">
                    {{ __('Log in') }}<svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2"></path>
                        <path d="M3 12h13l-3 -3"></path>
                        <path d="M13 15l3 -3"></path>
                    </svg>
                </a>
                {{-- <a href="{{ route('registration') }}" class="text-sm font-semibold leading-6 text-white">
                {{ __('Register') }}
                </a> --}}
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" x-show="open" x-cloak aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-10"></div>
            <div
                class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10 ">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <x-website-logo class='w-28 h-full' />
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400" x-on:click="open = ! open">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/25">
                        <div class="space-y-2 py-6">
                            <a href="{{ route('cancellation.and.refund.policy') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">
                                {{ __('Cancellation/Refund Policy') }}
                            </a>
                            <a href="{{ route('privacy.and.policy') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">
                                {{ __('Privacy Policy') }}
                            </a>
                            <a href="{{ route('terms.and.conditions') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">
                                {{ __('Terms & Conditions') }}
                            </a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('login') }}"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-white hover:bg-gray-800">
                                {{ __('Log in') }}
                            </a>
                            {{-- <a href="{{ route('registration') }}"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-white hover:bg-gray-800">
                            {{ __('Register') }}
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>