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
        <form action="{{ route(auth()->user()->roleName . 'user.membership.plan.update', $plan) }}" id="createUserForm"
            method="post" class="block">
            @csrf
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2 w-full m-auto">
                {{-- Membership duration --}}
                <div class="sm:col-span-3">
                    <x-input-label for="membership_duration" :value="__('Membership Duration')" />
                    <select name="membership_duration" id="membership_duration" autofocus
                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                        <option value="" disabled selected>{{ __('Select') }}</option>
                        @foreach ($plans as $item)
                            <option value="{{ $item->name }}" data-days="{{ $item->validity }}"
                                {{ $plan->name == $item->name ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('membership_duration')" class="mt-2" />
                </div>
                {{-- Payment Method --}}
                {{-- <div class="sm:col-span-3">
                    <x-input-label for="method_type" :value="__('Payment Method ')" />
                    <select name="method_type" id="method_type" autofocus
                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                        <option value="" disabled selected>{{ __('Select') }}</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method['name'] }}"
                                {{ $plan->method_type == $method['name'] ? 'selected' : '' }}>
                                {{ $method['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('method_type')" class="mt-2" />
                </div> --}}
                {{-- amount --}}
                <div class="sm:col-span-3">
                    <x-input-label for="amount" :value="__('Amount')" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" placeholder="Enter amount"
                        name="amount" :value="$plan->amount" required autofocus autocomplete="amount" />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>
                {{-- Remaining Aomunt --}}
                <div class="sm:col-span-3">
                    <x-input-label for="remaining_amount" :value="__('Remaining amount')" />
                    <x-text-input id="remaining_amount" class="block mt-1 w-full" type="number"
                        placeholder="Enter remaining amount" name="remaining_amount" :value="$plan->remaining_amount" required autofocus
                        autocomplete="remaining_amount" />
                    <x-input-error :messages="$errors->get('remaining_amount')" class="mt-2" />
                </div>
                {{-- Start date --}}
                <div class="sm:col-span-3">
                    <x-input-label for="start_date" :value="__('Start Date')" />
                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" placeholder="Enter start_date"
                        name="start_date" :value="dateFormat($plan->start_date, 'Y-m-d')" required autofocus autocomplete="start_date" />
                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>
                {{-- End date --}}
                <div class="sm:col-span-3">
                    <x-input-label for="end_date" :value="__('End Date')" />
                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" placeholder="Enter end_date"
                        name="end_date" :value="dateFormat($plan->end_date, 'Y-m-d')" required autofocus autocomplete="end_date" />
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>

                <div class="col-span-full">
                    <x-input-label for="note" :value="__('Note')" />
                    <textarea name="note" id="note" cols="3" rows="2"
                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm resize-y"
                        placeholder="Add note">{{ $plan->notes }}</textarea>
                    <x-input-error :messages="$errors->get('note')" class="mt-2" />
                </div>

                <div class="col-span-full">
                    <p class="text-red-500 font-medium">Note:- If you change amount then please add or remove transaction by
                        your own</p>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6 m-auto max-w-2xl">
                <a href="{{ route(auth()->user()->roleName . 'user.membership.plan.create', $plan->user) }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    </section>
@endsection
