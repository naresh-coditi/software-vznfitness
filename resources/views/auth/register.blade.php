<x-guest-layout>
    <section class="font-mono bg-gray-400 ">
        <!-- Container -->
        <div class="flex justify-center items-center">
            <!-- Row -->
            <div class="w-full flex md:rounded-md overflow-hidden h-screen">
                <!-- Col -->
                <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-5/12 bg-cover"
                    style="background-image: url('https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGd5bXxlbnwwfHwwfHx8MA%3D%3D')">
                </div>
                <!-- Col -->
                <div class="w-full lg:w-7/12 bg-white p-5 overflow-auto">
                    <h3 class="pt-4 text-2xl text-center">Create an Account!</h3>
                    <form action="{{ route('registration.store') }}" method="POST" class="">
                        @csrf
                        <div class="space-y-2 py-4">
                            <div class="sm:flex w-full gap-6">
                                {{-- First Name --}}
                                <div class="form-group w-full container">
                                    <x-input-label for="first_name" :value="__('First Name')" astrik />
                                    <x-text-input id="first_name" class="block mt-1 w-full" type="text"
                                        name="first_name" :value="old('first_name')" autofocus />
                                    <p class="text-red-500 font-bold pt-2"></p>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                {{-- Last Name --}}
                                <div class="w-full">
                                    <x-input-label for="last_name" :value="__('Last Name')" />
                                    <x-text-input id="last_name" class="block mt-1 w-full" type="text"
                                        name="last_name" :value="old('last_name')" autofocus />
                                    <p class="text-red-500 font-bold pt-2"></p>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="sm:flex w-full gap-6">
                                    {{-- Email --}}
                                    <div class="w-full container form-group">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email"
                                            name="email" :value="old('email')" autofocus />
                                        <p class="text-red-500 font-bold pt-2"></p>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    {{-- Phone --}}
                                    <div class="w-full container form-group">
                                        <x-input-label for="phone" :value="__('phone')" astrik />
                                        <x-text-input id="phone" class="block mt-1 w-full" type="number"
                                            name="phone" :value="old('phone')" autofocus autocomplete="phone"
                                            maxlength="10" minlength="10" />
                                        <p class="text-red-500 font-bold pt-2"></p>
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="md:flex items-center justify-between gap-6">
                                    {{-- Gender --}}
                                    <div class="w-full container form-group">
                                        <x-input-label for="gender" :value="__('Gender')" astrik />
                                        <div class="flex items-center gap-4 mt-1  md:flex-row flex-col">
                                            <label for="male" class="flex items-center gap-1">
                                                <input type="radio" checked name="gender" id="male" class="accent-orange-500"
                                                    value="male"
                                                    {{ old('gender') == 'male' ? 'checked' : '' }}>
                                                <span>{{ __('Male') }}</span>
                                            </label>
                                            <label for="female" class="flex items-center gap-1">
                                                <input type="radio" name="gender" id="female" value="female" class="accent-orange-500"
                                                 {{ old('gender') == 'female' ? 'checked' : '' }}>
                                                <span>{{ __('Female') }}</span>
                                            </label>
                                        </div>
                                        <p class="text-red-500 font-bold pt-2"></p>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>
                                    {{-- Branches --}}
                                    <div class="w-full  container form-group">
                                        <x-input-label for="branch" :value="__('Branch')" astrik />
                                        <select name="branch" id="branch"
                                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ old('branch') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name . ' | ' . $branch->location }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('branch')" class="mt-2" />
                                    </div>
                                </div>
                                {{-- Address --}}
                                <div>
                                    <x-input-label for="address" :value="__('Address')" />
                                    <textarea name="address" id="address" cols="3" rows="1"
                                        class="block mt-1 w-full border-gray-300  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm resize-y">{{ old('address') }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                                <div class="sm:flex w-full gap-6">
                                    {{-- Password --}}
                                    <div class="w-full container form-group">
                                        <x-input-label for="password" :value="__('Password')" astrik />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password"
                                            name="password" value="" autofocus />
                                        <p class="text-red-500 font-bold pt-2"></p>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="w-full container form-group">
                                        <x-input-label for="confirm_password" :value="__('Confirm Password')" astrik />
                                        <x-text-input id="confirm_password" class="block mt-1 w-full" type="password"
                                         name="confirm_password" value="" autofocus
                                            autocomplete="confirm_password" />
                                        <p class="text-red-500 font-bold pt-2"></p>
                                        <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-6 text-center">
                            <button id="submitButton" type="submit"
                                class="px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                                type="submit">
                                Register Account
                            </button>
                        </div>
                        <hr class="mb-6 border-t" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                                href="{{ route('login') }}">
                                Already have an account? Login!
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
