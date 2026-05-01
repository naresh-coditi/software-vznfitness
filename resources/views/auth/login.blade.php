<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="relative bg-gray-200 h-full 2xl:h-screen overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center " style="background-image: url('{{ asset('images/cover/test2.jpg') }}');"></div>
       
        
        <div class="flex items-center justify-center h-full">
            <div class="max-w-md mx-auto w-full">
                <div class="pt-6 flex justify-center w-full mb-2">
                    <div class="cursor-pointer flex items-center justify-center">
                        <a href="/" class="relative">
                            <x-website-logo class="w-28" />
                        </a>
                    </div>
                </div>
            <div class="bg-[#c2c6cc7a] relative rounded shadow-lg p-8  w-full ">
                
                <h2 class=" text-3xl text-gray-900 font-display font-semibold mb-1">Login</h2>
                <p class="text-[15px] text-gray-800">Access the <span class="text-orange-500">VZN</span> panel using your email and password.</p>
                <div class="mt-8 login_form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="login" :value="__('Email or Phone ')" />
                            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus placeholder="Enter your phone number or email address   " />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>
                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="bg-orange-600 text-gray-100 px-4 py-2 w-full rounded tracking-wide font-semibold focus:outline-none focus:shadow-outline shadow-lg">
                                Log In
                            </button>
                        </div>
                        
                        <div class="py-4 flex justify-around">
                            <a href="{{ route('user.login') }}" class=" text-sm flex items-center gap-2 text-gray-50">
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
            <div class="flex flex-col gap-2">
                
                <ul class="py-3 mt-10 px-2 flex items-center justify-center gap-4 text-sm font-medium text-white  leading-6 w-full">
                <li>
                    <a href="{{ route('privacy.and.policy') }}" class="relative whitespace-nowrap hover:text-amber-500 hover:underline">{{ __('Privacy Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('cancellation.and.refund.policy') }}" class="relative whitespace-nowrap hover:text-amber-500 hover:underline">{{ __('Cancellation/Refund Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('terms.and.conditions') }}" class="relative whitespace-nowrap hover:text-amber-500 hover:underline">{{ __('Terms and Conditions') }}</a>
                </li>
            </ul>
            <p class="text-center text-xs font-medium text-white  leading-6 w-full relative">©  2026 VZN Fitness.  ALL RIGHTS RESERVED.</p>
            </div>
            </div>
        </div>
        <!-- <div class="absolute bottom-0 w-full bg-black/30 text-white">
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
        </div> -->
    </div>
</x-guest-layout>
