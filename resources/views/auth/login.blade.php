<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="relative bg-gray-200 h-screen overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cover/test2.jpg') }}');"></div>
        <div class="flex items-center justify-center h-full">
            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl shadow-lg p-8 max-w-md w-full">
                <div class="pt-6 flex justify-start">
                    <div class="cursor-pointer flex items-center">
                        <a href="/">
                            <x-website-logo />
                        </a>
                    </div>
                </div>
                <h2 class="text-center text-4xl text-black font-display font-semibold">Login</h2>
                <div class="mt-12">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="login" :value="__('Phone / Email')" />
                            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="bg-orange-600 text-gray-100 p-4 w-full rounded-full tracking-wide font-semibold focus:outline-none focus:shadow-outline shadow-lg">
                                Log In
                            </button>
                        </div>
                        <div class="py-4 flex justify-around">
                            <a href="{{ route('user.login') }}" class="underline text-xs flex items-center gap-2 text-orange-600 hover:text-orange-800">
                                {{ __('Member Login') }}
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <g clip-path="url(#a)">
                                        <path fill="currentColor" fill-rule="evenodd" d="m13.5 6-2.906-3.737a1.978 1.978 0 0 0-3.48 1.694L7.375 5H1.942a1.942 1.942 0 0 0-.421 3.838L4.5 9.5l.457 2.744A3 3 0 0 0 8.69 14.65L13 13.5zm-5.197 7.2 3.272-.872.39-5.858L9.41 3.184a.478.478 0 0 0-.84.41l.26 1.042.466 1.864H1.942a.442.442 0 0 0-.096.874l2.98.662.987.22.167.997.457 2.744A1.5 1.5 0 0 0 8.303 13.2m7.195.103a.75.75 0 0 1-1.496-.106l.5-7a.75.75 0 1 1 1.496.106z" clip-rule="evenodd"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="a">
                                            <path fill="currentColor" d="M0 0h16v16H0z"></path>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 w-full bg-black/30 text-white">
            <ul class="py-5 px-6 flex items-center justify-center gap-24 text-sm font-medium leading-6 w-full">
                <li>
                    <a href="{{ route('privacy.and.policy') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden hover:text-orange-500">{{ __('Privacy Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('cancellation.and.refund.policy') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden hover:text-orange-500">{{ __('Cancellation/Refund Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('terms.and.conditions') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden hover:text-orange-500">{{ __('Terms and Conditions') }}</a>
                </li>
            </ul>
        </div>
    </div>
</x-guest-layout>
