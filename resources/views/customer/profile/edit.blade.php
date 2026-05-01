@extends('customer.layouts.main')
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route('user.profile.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('User') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route('user.profile.index') }}">{{ __('Profile') }}</a> &raquo;
                <a>{{ __('Edit Profile') }}</a>
            </span>
        </div>
    </div>
@endpush
@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div>
            <form action="{{ route('user.profile.update') }}" method="post" id="updateUserForm"
                enctype="multipart/form-data" class="space-y-4">
                @method('PUT')
                @csrf
                <div class="border-b-2 rounded-lg space-y-8">
                    <div class="flex items-center justify-between py-4 px-4">
                        <span>
                            {{ __('Personal Information') }}
                        </span>
                    </div>
                </div>
                <div class="xl:flex gap-6 w-full justify-between px-4 pb-8">
                    {{-- Profile Image --}}
                    <div class="xl:w-2/6 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                        <div
                            class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                            <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" id="profileImage"
                                src="{{ profileImage($user->image->path) }}" alt="Jese picture">
                            <div>
                                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Profile picture
                                </h3>
                                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                                    JPG, GIF or PNG. Max size of 800K
                                </div>
                                <div class="flex items-center">
                                    <input type="file" name="image" id="image" class="sr-only"
                                        onchange="setProfileImage(event)">
                                    <label for="image" type="button"
                                        class="cursor-pointer inline-flex items-center md:flex-row px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                                            </path>
                                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                        </svg>
                                        Upload picture
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-4/6 space-y-3">
                        <div class="sm:flex w-full gap-6">
                            {{-- First Name --}}
                            <div class="w-full">
                                <x-input-label for="first_name" :value="__('First Name')" astrik />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                    :value="$user->userProfile->first_name" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            {{-- Last Name --}}
                            <div class="w-full">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                    :value="$user->userProfile->last_name" autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>
                        <div class="sm:flex w-full gap-6">
                            {{-- Gender --}}
                            <div class="w-full">
                                <x-input-label for="gender" :value="__('Gender')" astrik />
                                <div class="flex md:items-center gap-4 mt-1 md:flex-row">
                                    <label for="male" class="flex items-center gap-1">
                                        <input type="radio" name="gender" id="male" value="male"
                                            class="accent-orange-500"
                                            {{ $user->userProfile->gender == 'Male' ? 'checked' : '' }}>
                                        <span>{{ __('Male') }}</span>
                                    </label>
                                    <label for="female" class="flex items-center gap-1">
                                        <input type="radio" name="gender" id="female" value="female"
                                            class="accent-orange-500"
                                            {{ $user->userProfile->gender == 'Female' ? 'checked' : '' }}>
                                        <span>{{ __('Female') }}</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="sm:flex w-full gap-6">
                                {{-- Email --}}
                                {{-- <div class="w-full">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                        :value="$user->email" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div> --}}

                                {{-- Phone --}}
                                <div class="w-full">
                                    <x-input-label for="phone" :value="__('phone')" astrik />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                                        :value="$user->phone" required autofocus autocomplete="phone" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                            {{-- Address --}}
                            <div>
                                <x-input-label for="address" :value="__('Address')" astrik />
                                <textarea required name="address" id="address" cols="10" rows="5"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm resize-y">{{ $user->userProfile->address }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="sm:flex justify-end pt-4">
            <x-primary-button class="ms-3">
                {{ __('Update') }}
            </x-primary-button>
        </div>
        </form>
        </div>
    </section>
    @push('script')
        <script type="text/javascript">
            // Profile image loader
            function setProfileImage(event) {
                const image = document.getElementById('profileImage');
                const reader = new FileReader();
                reader.onload = function() {
                    image.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
                return;
            }
        </script>
    @endpush
@endsection
