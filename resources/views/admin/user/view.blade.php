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
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a>
                &raquo;
                <a>{{ __('View Member') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <header class="pb-2 border-b border-gray-500">
            <h2 class="text-gray-800 text-xl">{{ __('Personal Information') }}</h2>
        </header>
        <div class="md:flex gap-8 pt-4">
            <div class="flex flex-col xl:flex-row justify-between w-full gap-10">
                <div class="sm:w-2/4 2xl:col-span-2">
                    <div
                        class="xl:block xl:space-x-0 2xl:space-x-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <h3 class="mb-1 text-base font-bold text-gray-900">Profile picture</h3>
                        <img class="mb-4 rounded-lg w-56 h-56 sm:mb-0 xl:mb-4 2xl:mb-0 object-cover" id="profileImage"
                            src="{{ profileImage($user->image->path) }}" alt="Jese picture">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-10 w-full">
                    <x-table-element class="text-sm sm:w-2/4">
                        <tbody>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('First Name') }}</div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    {{ $user->userProfile->first_name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Last Name') }}</div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    {{ $user->userProfile->last_name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Gender') }}</div>
                                </x-table-data>
                                <x-table-data class="px-6 py-3 border-b border-blue-gray-50">
                                    <p class="text-sm">{{ $user->userProfile->gender }}</p>
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Email') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->email }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Remaining Balance') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->latestPlan->remaining_amount }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Total Amount Paid') }}</div>
                                </x-table-data>
                                <x-table-data>
                                    {{ $user->totalAmountPaid }}
                                </x-table-data>
                            </x-table-row>
                        </tbody>
                    </x-table-element>
                    <x-table-element class="text-sm sm:w-2/4">
                        <tbody>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Address') }}</div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    {{ $user->userProfile->address }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Phone Number') }} </div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    {{ $user->phone }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Account Type') }}</div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    <x-status-tag-element label="{{ $user->userRoleType['label'] }}"
                                        color="{{ $user->userRoleType['color'] }}" />
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Membership Name') }}</div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    {{ $user->latestPlan->name }}
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Created By') }} </div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    <span>{{ $user->userProfile->createdByName }}</span>
                                </x-table-data>
                            </x-table-row>
                            <x-table-row>
                                <x-table-data>
                                    <div> {{ __('Note') }} </div>
                                </x-table-data>
                                <x-table-data class="text-sm px-6 py-3 text-left">
                                    <span>{{ $user->latestPlan->notes }}</span>
                                </x-table-data>
                            </x-table-row>
                        </tbody>
                    </x-table-element>
                </div>
            </div>
        </div>
    </section>
@endsection
