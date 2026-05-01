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
            <form action="{{ route(auth()->user()->roleName . 'user.membership.plan.store', $user) }}" id="createUserForm"
                method="post" class="block">
                @csrf
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2 w-full m-auto">
                    {{-- Membership duration --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="membership_duration" :value="__('Membership Duration')" />
                        <select name="membership_duration" id="membership_duration" autofocus
                            class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                            <option value="" disabled selected>{{ __('Select') }}</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->name }}" data-days="{{ $plan->validity }}"
                                    {{ old('membership_duration') == $plan->name ? 'selected' : '' }}>
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
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" placeholder="Enter amount"
                            name="amount" :value="old('amount')" required autofocus autocomplete="amount" />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    {{-- Remaining Aomunt --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="remaining_amount" :value="__('Remaining amount')" />
                        <x-text-input id="remaining_amount" class="block mt-1 w-full" type="number"
                            placeholder="Enter remaining amount" name="remaining_amount" :value="old('remaining_amount')" required
                            autofocus autocomplete="remaining_amount" />
                        <x-input-error :messages="$errors->get('remaining_amount')" class="mt-2" />
                    </div>
                    {{-- Start date --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date"
                            placeholder="Enter start_date" name="start_date" :value="old('start_date')" required autofocus
                            autocomplete="start_date" />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                    {{-- End date --}}
                    <div class="sm:col-span-3">
                        <x-input-label for="end_date" :value="__('End Date')" />
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" placeholder="Enter end_date"
                            name="end_date" :value="old('end_date')" required autofocus autocomplete="end_date" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>

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
                <div class="mt-6 flex items-center justify-end gap-x-6 m-auto max-w-2xl">
                    <a href="{{ route(auth()->user()->roleName . 'user.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Submit</x-primary-button>
                </div>
            </form>
        </div>
        <section>
            <div class="max-w-6xl m-auto border-x mt-14 text-xs bg-white rounded-md">
                <x-table-element>
                    <thead>
                        <x-table-row>
                            <x-table-head>
                                {{ __('Sr No.') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Plan Name') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Amount') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Remaining Balance') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Start date') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('End date') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Action') }}
                            </x-table-head>
                        </x-table-row>
                    </thead>
                    <tbody>
                        @forelse ($membershipPlans as $key => $plan)
                            <x-table-row>
                                <x-table-data>
                                    <span>{{ $key + $membershipPlans->firstItem() }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $plan->name }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $plan->amount }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ $plan->remaining_amount }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ dateFormat($plan->start_date) }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <span>{{ dateFormat($plan->end_date) }}</span>
                                </x-table-data>
                                <x-table-data>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route(auth()->user()->roleName . 'user.membership.plan.edit', $plan) }}"
                                            class="cursor-pointer hover:text-blue-500  flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 576 512">
                                                <title>Edit</title>
                                                <path
                                                    d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                </path>
                                            </svg>
                                        </a>
                                        <x-delete-confirmation-modal :values="$plan" :message="'Are you sure you want to remove this transaction ?'"
                                            routename="{{ route(auth()->user()->roleName . 'user.membership.plan.delete', $plan) }}" />
                                    </div>
                                </x-table-data>
                            </x-table-row>
                        @empty
                            <x-table-row>
                                <x-table-data colspan="8">
                                    {{ __('No Record Found') }}
                                </x-table-data>
                            </x-table-row>
                        @endforelse
                    </tbody>
                </x-table-element>
                <div>{{ $membershipPlans->links() }}</div>
            </div>
        </section>
    </section>

    @push('script')
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
