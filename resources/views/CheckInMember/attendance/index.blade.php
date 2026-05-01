@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
<title>{{ __('Manage Attendance') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
<div class="pl-6 py-2 md:mt-10 mt-5 text-xl font-bold">
    <span>{{ __('Manage Attendace') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a>{{ __('Attendance') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<div class="w-full px-6 mt-2 py-2">
    <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center bg-white p-2 rounded-md">
                <h3 class="font-semibold text-lg text-gray-700 flex items-center">
                    {{ __('Current Date :') }}
                    <span class="ml-2 text-orange-600">{{ now()->format('l, F j, Y') }}</span>
                </h3>
            </div>
        <div class="items-center bg-white p-2 w-full md:w-fit mb-1 rounded-md">
            <h3 class="font-semibold text-lg flex flex-col md:flex-row items-center text-center md:text-left">
                {{ __('Checked-In') }} {{ request('date') ? __('on ') . request('date') : __('Today') }} :
                <span class="text-orange-600 text-2xl ml-0 md:ml-2">{{ $attendenceCount }}</span>
            </h3>
        </div>
    </div>

    {{-- Responsive Table --}}
    <x-table-element>
        <form action="" method="get">
            <span class="flex justify-between items-center mb-4 w-full p-2 rounded-lg">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-x-4">
                    <!-- Search Input -->
                    <div class="w-fit">
                        <label for="search" class="sr-only">Search</label>
                        <input id="search" type="search"
                            class="border-0 ring-1 ring-slate-400 focus:ring-1 focus:ring-orange-600 focus:outline-none rounded-md m-2 text-sm w-full"
                            name="search" value="{{ $request->search }}" placeholder="Search by Name or Member ID" />
                    </div>
                    <!-- Search Button -->
                    <div class="w-full md:w-auto pt-3 md:pt-0 md:text-center text-right flex justify-between">
                        <button type="submit" aria-label="Search" class="bg-orange-100 rounded-md text-sm py-2 px-4 border border-orange-500 text-orange-500 hover:bg-orange-200">
                            Search
                        </button>
                    </div>
                </div>
                <div>
                    <input type="date" id="calendar" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" onchange="this.form.submit()" name="date" value="{{ request('date') }}">
                </div>
            </span>

        </form>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>{{ __('Sr No.') }}</x-table-head>
                <x-table-head class="flex justify-center">{{ __('Profile') }}</x-table-head>
                <x-table-head>{{ __('Contact No.') }}</x-table-head>
                <x-table-head>{{ __('Email') }}</x-table-head>
                <x-table-head>{{ __('Check In Time') }}</x-table-head>
                <x-table-head>{{ __('Date') }}</x-table-head>
                <!-- <x-table-head>{{ __('Action') }}</x-table-head> -->
            </x-table-row>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($attendance as $date => $day)
            @foreach ($day as $memberId => $attendance)
            <x-table-row>
                <x-table-data>{{ $loop->iteration }}</x-table-data>
                <x-table-data>
                    <span class="flex flex-col items-center">
                        @if($attendance[0]->user->image->path)
                        <img class="rounded-full w-16 h-16 object-cover hover:scale-95 cursor-pointer"
                            id="profileImage"
                            src="{{ profileImage($attendance[0]->user->image->path) }}" alt="Profile Picture">

                        @elseif($attendance[0]->user->userProfile->gender == 'Male')
                        <svg class="w-12 h-12 hover:scale-95 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor">
                            <path d="m14.145 16.629c-.04-.527-.064-1.142-.064-1.762 0-.255.004-.51.012-.763l-.001.037c.731-.76 1.219-1.758 1.333-2.868l.002-.021c.339-.028.874-.358 1.03-1.666.016-.074.025-.16.025-.248 0-.396-.188-.747-.48-.97l-.003-.002c.552-1.66 1.698-6.796-2.121-7.326-.393-.69-1.399-1.04-2.707-1.04-5.233.096-5.864 3.951-4.72 8.366-.294.226-.482.577-.482.972 0 .088.009.174.027.257l-.001-.008c.16 1.306.691 1.638 1.03 1.666.127 1.134.628 2.133 1.374 2.888.007.214.011.466.011.718 0 .623-.023 1.24-.069 1.851l.005-.081c-1.038 2.784-8.026 2.002-8.346 7.371h22.458c-.322-5.369-7.278-4.587-8.314-7.371z"></path>
                        </svg>
                        @else
                        <svg class="w-12 h-12 hover:scale-95 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor">
                            <path d="m14.041 16.683c-.015-.168-.026-.439-.035-.72 2.549-.261 4.338-.872 4.338-1.585-.007 0-.006-.03-.006-.041-1.906-1.718 1.652-13.92-4.971-13.674-.555-.418-1.256-.669-2.015-.669-.061 0-.121.002-.181.005h.008c-8.971.678-5.004 12.203-7.049 14.378h-.004s0 0 0 0c.008.698 1.736 1.298 4.211 1.566-.007.17-.022.381-.054.734-1.027 2.77-7.962 1.994-8.282 7.323h22.294c-.319-5.33-7.225-4.554-8.253-7.317z"></path>
                        </svg>
                        @endif
                        <span class="font-extrabold">{{ $attendance[0]->user->member_id }}</span>
                        <span>{{ $attendance[0]->user->userProfile->fullName }}</span>
                    </span>
                </x-table-data>
                <x-table-data>{{ $attendance[0]->user->phone }}</x-table-data>
                <x-table-data>{{ $attendance[0]->user->email }}</x-table-data>
                <x-table-data>
                    <div class="flex flex-col gap-5 items-start space-y-1">
                        @foreach ($attendance as $attende)
                        <span class="flex flex-row items-center gap-5">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="timing-morning" class="form-checkbox rounded-full text-orange-600" {{ ($attende->timing == 'Morning' || $attende->timing == 'Evening') ? 'checked' : '' }} disabled>
                                <span class="ml-2">{{ $attende->timing }}</span>
                            </label>
                            <span>{{ date('H:i:s', strtotime($attende->created_at)) }}</span>
                        </span>
                        @endforeach
                    </div>
                </x-table-data>
                <x-table-data>{{ dateFormat($attendance[0]->created_at) }}</x-table-data>
                {{-- <x-table-data class="flex flex-row items-center gap-2">
                    <span>
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M20.188 10.934c.388.472.582.707.582 1.066c0 .359-.194.594-.582 1.066C18.768 14.79 15.636 18 12 18c-3.636 0-6.768-3.21-8.188-4.934c-.388-.472-.582-.707-.582-1.066c0-.359.194-.594.582-1.066C5.232 9.21 8.364 6 12 6c3.636 0 6.768 3.21 8.188 4.934Z"></path></g></svg>
                    </span>
                    <span class="flex flex-row items-center cursor-pointer">
                         <svg class="w-6 h-6 hover:scale-105" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>
                    </span>
                    <span class="flex flex-row items-center cursor-pointer">
                    <svg class="w-7 h-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg" id="mdi-delete" viewBox="0 0 24 24"><path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"></path></svg>
                    </span>
                </x-table-data> --}}
            </x-table-row>
            @endforeach
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">
                    {{ __('No Attendance found') }}
                </td>
            </tr>
            @endforelse
        </tbody>

    </x-table-element>


    @endsection

    @push('script')

    @endpush