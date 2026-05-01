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
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}">{{ __('Leads') }}</a>
            &raquo;
            <a>{{ __('View Lead') }}</a>
        </span>
    </div>
</div>
@endpush

@section('main-section')

<section class="w-full px-6 mt-2 py-6">
    <h2 class="text-gray-800 text-xl pb-2 border-b border-gray-500">{{ __('Personal Information') }}</h2>
    <div class="flex-col items-center p-3">
        <div class="flex justify-center w-full">
            {{-- Profile Image --}}
            <div class="w-1/3 flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-md p-6">
            <div class="relative">
                <img class="rounded-full w-32 h-32 object-cover border-4 border-gray-300 shadow-sm" id="profileImage"
                src="{{ profileImage($user->image->path) }}" alt="User picture">
            </div>
            <h2 class="mt-4 text-lg font-semibold text-gray-800">Profile Picture</h2>
            </div>
        </div>

    <!--  -->
    <div class="md:flex gap-3">
        <div class="flex flex-col xl:flex-row justify-between w-full gap-10">
            <div class="flex justify-around p-5 sm:flex-row gap-10 w-full md:px-16">
                <div class="flex gap-10 items-center">
                     <x-table-element class="text-sm  sm:w-2/4">
                    <tbody>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('First Name') }}</div>
                            </x-table-data>
                            <x-table-data class="text-sm px-6 py-3 text-left">
                                {{ $user->first_name }}
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Last Name') }}</div>
                            </x-table-data>
                            <x-table-data class="text-sm px-6 py-3 text-left">
                                {{ $user->last_name }}
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Gender') }}</div>
                            </x-table-data>
                            <x-table-data class="px-6 py-3 border-b border-blue-gray-50">
                                <p class="text-sm">{{ $user->gender }}</p>
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Phone') }}</div>
                            </x-table-data>
                            <x-table-data>
                                {{ $user->phone }}
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Membership Interested') }}</div>
                            </x-table-data>
                            <x-table-data>
                                {{ $user->membership_interested }}
                            </x-table-data>
                            <!--  -->
                        </x-table-row>
                    </tbody>
                </x-table-element>
                <x-table-element class="text-sm  sm:w-2/4">
                    <tbody>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Source') }}</div>
                            </x-table-data>
                            <x-table-data>
                                {{ $user->source }}
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Note') }}</div>
                            </x-table-data>
                            <x-table-data>
                                {{ $user->note }}
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Created By') }}</div>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->createdBy->userProfile->fullName ?? '' }}</span>
                            </x-table-data>
                        </x-table-row>
                        <x-table-row>
                            <x-table-data>
                                <div class="text-base font-medium"> {{ __('Updated By') }}</div>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->updatedBy->userProfile->fullName ?? '' }}</span>
                            </x-table-data>
                        </x-table-row>
                    </tbody>
                </x-table-element>
                </div>
               
            </div>
        </div>
    </div>
    </div>
    </div>

</section>
@endsection