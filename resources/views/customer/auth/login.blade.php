<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="relative bg-gray-200 h-screen overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/cover/test2.jpg') }}');"></div>
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
                 
                <h2 class="text-center text-4xl text-black font-display font-semibold">Log in</h2>
                <div class="mt-12">
                    <form method="POST" action="{{ route('user.login') }}" class="flex items-center">
                        @csrf
                        <!-- Phone Number -->
                        <div class="w-full relative">
                            <x-input-label for="login" :value="__('Phone Number')" />
                            <x-text-input id="login" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus placeholder="Enter your phone number     " />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            <button type="submit" class="bg-orange-600 text-gray-100 p-1.5 px-3 rounded flex gap-2 items-center justify-center mt-4 font-semibold font-display focus:outline-none focus:shadow-outline shadow-lg  w-full">
                                Login<svg class="w-6 h-6 m-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="-5 -5 24 24" fill="currentColor">
                                    <path d="m10.586 5.657-3.95-3.95A1 1 0 0 1 8.05.293l5.657 5.657a.997.997 0 0 1 0 1.414L8.05 13.021a1 1 0 1 1-1.414-1.414l3.95-3.95H1a1 1 0 1 1 0-2h9.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div class="mt-8 text-sm font-display font-semibold text-gray-700 flex justify-center">
                        <a href="{{ route('login') }}" class="text-sm flex items-center gap-2 text-gray-50">
                            <span>{{ __('Staff Login ') }}</span>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 1200" fill="currentColor">
                                <path d="M1200,972.138V556.629c-2.192-43.973-37.788-75.725-76.898-76.253H936.995 c-53.196-40.854-90.897-97.553-142.165-138.61c-18.094-14.432-32.095-30.479-42.003-48.142 c-32.214-63.281-12.695-136.954-58.481-187.399c-92.008-39.482-202.231,15.751-233.279,102.423 c-24.404,70.78-8.051,141.366,22.294,203.877c-109.856-0.182-219.71,0.708-329.564,1.292C64.363,420.495,0.594,480.709,0,566.321 c0.244,86.275,74.623,149.017,153.796,150.565h129.241c4.308,25.417,12.708,48.465,25.202,69.144 c-7.239,53.145,9.327,105.247,41.357,142.812c17.576,306.75,419.443,124.761,569.951,120.193h203.555 C1167.384,1046.939,1199.472,1011.445,1200,972.138z M922.778,972.138c-120.425,2.591-531.908,184.658-492.406-76.253 c-43.545-23.47-60.301-86.285-33.603-126.009c-40.566-40.005-52.119-90.265-12.924-129.887c-38.772,0-77.114-0.216-115.024-0.646 s-76.252-0.646-115.024-0.646c-44.371-0.933-75.122-33.487-75.606-72.375c1.014-45.975,35.914-75.136,75.606-75.605 c150.384-0.008,298.632-1.276,438.126-1.292c-12.555-100.763-132.769-237.585-10.017-316.963 c19.652-9.652,35.367-13.749,55.896-10.017c3.446,1.723,5.385,3.447,5.816,5.17c0.431,1.723,1.076,4.523,1.938,8.4 c13.044,79.87,25.221,159.73,87.237,212.601c68.263,52.343,108.514,134.749,186.752,168.014h3.231V972.138z"></path>
                            </svg>
                        </a>
                    </div>
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
        <!-- <div class="absolute bottom-0 w-full bg-black/30 text-white">
            <ul class="py-5 px-6 flex items-center justify-center gap-24 text-sm font-medium leading-6 w-full">
                <li>
                    <a href="{{ route('privacy.and.policy') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden">{{ __('Privacy Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('cancellation.and.refund.policy') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden">{{ __('Cancellation/Refund Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('terms.and.conditions') }}" class="relative hover:after:block after:w-full after:border after:border-white after:absolute after:-bottom-2 after:hidden">{{ __('Terms and Conditions') }}</a>
                </li>
            </ul>
        </div> -->
    </div>
</x-guest-layout>
