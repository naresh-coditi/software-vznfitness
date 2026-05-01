@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Members') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'user.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Members') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a> &raquo;
                <a>{{ __('Create Member') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'user.store') }}" id="createUserForm" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_type" value="1">
                <div class="space-y-12">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-6 md:grid-cols-1">
                        <!-- <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                            </div> -->
                        {{-- Profile image --}}
                       <center> <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2 border-4 border-white rounded-lg shadow-lg w-fit pl-10 pr-10 pt-2 pb-2">
                            <div class="col-span-full">
                                <!-- <label for="photo"
                                    class="block text-lg font-semibold leading-6 text-gray-900">Profile Picture</label> -->
                                <div class="mt-2 flex items-center gap-x-3">
                                    <input type="file" name="image" id="image" class="sr-only"
                                        onchange="setProfileImage(event)">
                                    <img class="mb-4 rounded-full w-20 h-20 sm:mb-0 xl:mb-4 2xl:mb-0 bg-white" id="profileImage"
                                        src="{{ profileImage() }}" >
                                    <label for="image" type="button"
                                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Select Profile Picture</label>
                                </div>
                            </div>
                        </div></center>
                    </div>

                    <div class="md:flex w-full gap-10">
                        <!-- <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                            </div> -->

                        <div class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                            {{-- First Name --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="first_name" :value="__('First Name')" astrik />
                                <x-text-input id="first_name" class="" type="text" name="first_name"
                                    :value="$lead->first_name ? $lead->first_name : old('first_name')" required autofocus />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

                            </div>
                            {{-- last namae --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                    :value="$lead->last_name ? $lead->last_name : old('last_name')" autofocus />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                            {{-- email --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                    :value="$lead->email ? $lead->email : old('email')" autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            {{-- Branch --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="branch" :value="__('Branch')" astrik />
                                <select name="branch" id="branch"
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ old('branch') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name . ' | ' . $branch->location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('branch')" class="mt-2" />
                            </div>
                            {{-- phone --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="phone" :value="__('Phone')" astrik />
                                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                                    :value="$lead->phone ? $lead->phone : old('phone')" required autofocus autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            {{-- gender --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="gender" :value="__('Gender')" astrik />
                                <div class="flex items-center gap-4 mt-1  md:flex-row">
                                    <label for="male" class="flex items-center gap-1">
                                        <input type="radio" checked name="gender" id="male" value="male"
                                            class="accent-orange-500"
                                            {{ ($lead->gender ? $lead->gender : old('gender')) == 'male' ? 'checked' : '' }}>
                                        <span>{{ __('Male') }}</span>
                                    </label>
                                    <label for="female" class="flex items-center gap-1">
                                        <input type="radio" name="gender" id="female" value="female"
                                            class="accent-orange-500"
                                            {{ ($lead->gender ? $lead->gender : old('gender')) == 'female' ? 'checked' : '' }}>
                                        <span>{{ __('Female') }}</span>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            {{-- address --}}
                            <div class="sm:col-span-6">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea name="address" id="address" cols="3" rows="1"
                                    class="block mt-1 w-full border-gray-300  focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm resize-y">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                            {{-- password --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="password" :value="__('Password')" astrik />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    :value="old('password')" required autofocus autocomplete="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            {{-- confirm password --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="confirm_password" :value="__('Confirm Password')" astrik />
                                <x-text-input id="confirm_password" class="block mt-1 w-full" type="password"
                                    name="confirm_password" required autofocus autocomplete="confirm_password" />
                                <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="space-y-10 md:col-span-2 w-full">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                                {{-- Membership duration --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="membership_duration" :value="__('Membership Duration')" />
                                    <select name="membership_duration" id="membership_duration" autofocus
                                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                        <option value="" disabled selected>{{ __('Select') }}</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->name }}" data-days="{{ $plan->validity }}"
                                                {{ ($lead ? $lead->membership_interested : old('membership_duration') == $plan->name) ? 'selected' : '' }}>
                                                {{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('membership_duration')" class="mt-2" />
                                </div>
                                {{-- Payment Method --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="method_type" :value="__('Payment Method ')" />
                                    <select name="method_type" id="method_type" autofocus
                                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                        <option value="" disabled selected>{{ __('Select') }}</option>
                                        @foreach ($paymentMethods as $method)
                                            <option value="{{ $method['name'] }}"
                                                {{ old('method_type') == $method['name'] ? 'selected' : '' }}>
                                                {{ $method['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('method_type')" class="mt-2" />
                                </div>
                                {{-- amount --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="amount" :value="__('Amount')" />
                                    <x-text-input id="amount" class="block mt-1 w-full" type="number"
                                        placeholder="Enter amount" name="amount" :value="old('amount')" required autofocus
                                        autocomplete="amount" />
                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                </div>
                                {{-- Remaining Aomunt --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="remaining_amount" :value="__('Remaining amount')" />
                                    <x-text-input id="remaining_amount" class="block mt-1 w-full" type="number"
                                        placeholder="Enter remaining amount" name="remaining_amount" :value="old('remaining_amount')"
                                        autofocus autocomplete="remaining_amount" />
                                    <x-input-error :messages="$errors->get('remaining_amount')" class="mt-2" />
                                </div>
                                {{-- Start date --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date"
                                        placeholder="Enter start_date" name="start_date" :value="old('start_date')" required
                                        autofocus autocomplete="start_date" />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>

                                {{-- End date --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="end_date" :value="__('End Date')" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="date"
                                        placeholder="Enter end_date" name="end_date" :value="old('end_date')" required autofocus
                                        autocomplete="end_date" />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                                {{-- Notes --}}
                                <div class="col-span-full">
                                    <x-input-label for="note" :value="__('Note')" />
                                    <textarea name="note" id="note" cols="3" rows="2"
                                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm resize-y"
                                        placeholder="Add note">{{ old('note') }}</textarea>
                                    <x-input-error :messages="$errors->get('note')" class="mt-2" />
                                </div>

                                <div class="col-span-full">
                                    <p class="text-red-500 font-medium">Note:- Now transaction details will automatic saved
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                            <div>
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Membeship Details</h2>
                            </div>


                        </div> -->
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'user.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Submit</x-primary-button>
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

            function createUser() {
                return {
                    personalInfo: true,
                    sidebar: true,
                    paymentOrder: true,
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const membershipDuration = document.getElementById('membership_duration');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');

                function calculateEndDate() {
                    const selectedPlan = membershipDuration.options[membershipDuration.selectedIndex];
                    const validityDays = parseInt(selectedPlan.getAttribute('data-days'), 10);
                    const startDateValue = startDateInput.value;

                    if (!isNaN(validityDays) && startDateValue) {
                        const startDate = new Date(startDateValue);
                        const adjustedStartDate = new Date(startDate); // Clone the start date

                        // If the validity is more than 2 months (60 days)
                        if (validityDays >= 60) {
                            const monthsToAdd = Math.floor(validityDays / 30); // Convert validity days into months
                            adjustedStartDate.setMonth(adjustedStartDate.getMonth() + monthsToAdd);
                            // Adjust for month overflow (e.g., if going from Jan 31 to Feb, handle Feb's shorter days)
                            if (adjustedStartDate.getDate() !== startDate.getDate()) {
                                adjustedStartDate.setDate(
                                0); // Set to last day of the previous month if overflow happens
                            }
                        } else {
                            // Add validity days if less than 2 months
                            adjustedStartDate.setDate(adjustedStartDate.getDate() + validityDays);
                        }

                        // Format the date as YYYY-MM-DD
                        const year = adjustedStartDate.getFullYear();
                        const month = String(adjustedStartDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                        const day = String(adjustedStartDate.getDate()).padStart(2, '0');

                        endDateInput.value = `${year}-${month}-${day}`;
                    }
                }

                // Listen for changes on membership duration and start date
                membershipDuration.addEventListener('change', calculateEndDate);
                startDateInput.addEventListener('change', calculateEndDate);
            });
        </script>
    @endpush
@endsection
