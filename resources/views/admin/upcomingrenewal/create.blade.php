@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Upcoming Renwal') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Upcoming Renwal') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.index') }}">{{ __('Upcoming Renwal') }}</a>
                &raquo;
                <a>{{ __('Create') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'upcoming.renewal.store', $currentPlan) }}" method="post">
                @csrf
                <div class="space-y-12">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                        <div>
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Membeship Details</h2>
                        </div>

                        <div class="max-w-2xl space-y-10 md:col-span-2">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                                {{-- Membership duration --}}
                                    <div class="sm:col-span-3">
                                    <x-input-label for="membership_duration" :value="__('Membership Duration')" />
                                    <select name="membership_duration" id="membership_duration" autofocus required
                                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                        <option value="" disabled selected>{{ __('Select') }}</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->name }}" {{($currentPlan->name==$plan->name) ? 'selected' : ''}} >{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('membership_duration')" class="mt-2" />
                                </div>
                                {{-- Payment Method --}}
                                <div class="sm:col-span-3">
                                    <x-input-label for="method_type" :value="__('Payment Method ')" />
                                    <select name="method_type" id="method_type" autofocus required
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
                                        required autofocus autocomplete="remaining_amount" />
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
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.index') }}"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                    <x-primary-button>Submit</x-primary-button>
                </div>
            </form>
        </div>
    </section>
@endsection
