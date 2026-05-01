@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Staffs') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'staff.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Satff') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'staff.index') }}">{{ __('Satff') }}</a> &raquo;
                <a>{{ __('Edit Staff') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'staff.update', $user) }}" id="createUserForm" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-12">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                        <div>
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                        </div>
                        {{-- Profile image --}}
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                            <div class="col-span-full">
                                <label for="photo"
                                    class="block text-sm font-semibold leading-6 text-gray-900">Photo</label>
                                <div class="mt-2 flex items-center gap-x-3">
                                    <input type="file" name="image" id="image" class="sr-only"
                                        onchange="setProfileImage(event)">
                                    <img class="mb-4 rounded-full w-16 h-16 sm:mb-0 xl:mb-4 2xl:mb-0" id="profileImage"
                                        src="{{ profileImage($user->image->path) }}" alt="Jese picture">
                                    <label for="image" type="button"
                                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                        <div>
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                        </div>

                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                            {{-- First Name --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="first_name" :value="__('First Name')" astrik />
                                <x-text-input id="first_name" class="" type="text" name="first_name"
                                    :value="$user->userProfile->first_name" required autofocus />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

                            </div>
                            {{-- last namae --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                    :value="$user->userProfile->last_name" autofocus />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            {{-- Branch --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="branch" :value="__('Branch')" astrik />
                                <select name="branch" id="branch"
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name . ' | ' . $branch->location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('branch')" class="mt-2" />
                            </div>
                            {{-- email --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                    :value="$user->email" autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            {{-- phone --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="phone" :value="__('Phone')" astrik />
                                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                                    :value="$user->phone" required autofocus autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            {{-- gender --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="gender" :value="__('Gender')" astrik />
                                <div class="flex items-center gap-4 mt-1  md:flex-row">
                                    <label for="male" class="flex items-center gap-1">
                                        <input type="radio" checked name="gender" id="male" value="male"
                                            class="accent-orange-500"
                                            {{ $user->userProfile->gender == 'male' ? 'checked' : '' }}>
                                        <span>{{ __('Male') }}</span>
                                    </label>
                                    <label for="female" class="flex items-center gap-1">
                                        <input type="radio" name="gender" id="female" value="female"
                                            class="accent-orange-500"
                                            {{ $user->userProfile->gender == 'female' ? 'checked' : '' }}>
                                        <span>{{ __('Female') }}</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            {{-- address --}}
                            <div class="sm:col-span-6">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea required name="address" id="address" cols="3" rows="1"
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm resize-y">{{ $user->userProfile->address }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'staff.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Update</x-primary-button>
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

            function updateUser() {
                return {
                    personalInfo: true,
                    sidebar: true
                }
            }
        </script>
    @endpush
@endsection
