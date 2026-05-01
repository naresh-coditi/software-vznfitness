@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Leads') }}</title>
@endpush

@push('breadcrum')
<div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
    <a href="{{ route(auth()->user()->roleName . 'lead.index') }}">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
            <path d="M0 0h24v24H0V0z" fill="none"></path>
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
        </svg>
    </a>
    <div>
        <span>{{ __('Leads') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}">{{ __('Leads') }}</a> &raquo;
            <a>{{ __('Update Lead') }}</a>
        </span>
    </div>
</div>
@endpush

@section('main-section')
<section class="w-full px-6 mt-2 py-6">
    <div>
        <form action="{{ route(auth()->user()->roleName . 'lead.update', $user) }}" id="updateUserForm" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_type" value="1">
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    </div>
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

                    <!--  -->
<hr>
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2 ">

                        {{-- First Name --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="first_name" :value="__('First Name')" astrik />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                :value="$user->first_name" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        {{-- last namae --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                :value="$user->last_name" autofocus />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                        {{-- gender --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="gender" :value="__('Gender')" astrik />
                            <div class="flex items-center gap-4 mt-1 md:flex-row">
                                <label for="male" class="flex items-center gap-1">
                                    <input type="radio" name="gender" id="male" value="male"
                                        class="accent-orange-500" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                    <span>{{ __('Male') }}</span>
                                </label>
                                <label for="female" class="flex items-center gap-1">
                                    <input type="radio" name="gender" id="female" value="female"
                                        class="accent-orange-500" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                    <span>{{ __('Female') }}</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        {{-- phone --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="phone" :value="__('phone')" astrik />
                            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                                :value="$user->phone" required autofocus autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        {{-- Follow up date --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="follow_up_date" :value="__('Follow Up Date')" astrik />
                            <x-text-input id="follow_up_date" class="block mt-1 w-full" type="date"
                                name="follow_up_date" :value="dateFormat($user->follow_up_date, 'Y-m-d')" required autofocus
                                autocomplete="follow_up_date" />
                            <x-input-error :messages="$errors->get('follow_up_date')" class="mt-2" />
                        </div>
                        {{-- Offer amount --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="amount_offer" :value="__('Amount offer')" />
                            <x-text-input id="amount_offer" class="block mt-1 w-full" type="number" name="amount_offer"
                                :value="$user->amount_offer" autofocus autocomplete="amount_offer" />
                            <x-input-error :messages="$errors->get('amount_offer')" class="mt-2" />
                        </div>
                        {{-- Lead Source --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="source" :value="__('Source')" />
                            <select name="source" id="source"
                                class="source block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm"
                                type="text" name="source" :value="$user->source" autofocus autocomplete="source">
                                <option value="" disabled selected>Select</option>
                                @foreach ($sources as $source)
                                <option value="{{ $source['id'] }}"
                                    {{ $user->source == $source['id'] ? 'selected' : '' }}>
                                    {{ $source['name'] }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>
                        {{-- membership_interested --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="membership_interested" :value="__('Membership Interested')" />
                            <select name="membership_interested" id="membership_interested"
                                class="membership_interested" class="block mt-1 border-gray-300  rounded-md shadow-sm">
                                <option value="" checked>Select Member</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->name }}"
                                    {{ $user->membership_interested == $plan->name ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('membership_interested')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6 text-black font-medium">
                <a href="{{ route(auth()->user()->roleName . 'lead.index') }}" class="">Cancel</a>
                <button type="submit"
                    class="rounded-md bg-orange-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">Update</button>
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
            paymentInfo: false,
            paymentModal: false,
            sidebar: true,
        }
    }
</script>
@endpush
@endsection