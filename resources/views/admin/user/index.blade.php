@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Members') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')

<!-- Breadcrum -->
<div class="flex gap-4 items-center justify-between">
    <div class="py-2 text-xl font-bold flex flex-row items-center">
        <div>
            <span>{{ __('Members') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a>{{ __('Members') }}</a>
            </span>
        </div>
        <div>
            @can('isAdmin')
            <x-member-pop-up :one="$monthMembershipCount[0]" :three="$monthMembershipCount[1]" :six="$monthMembershipCount[2]" :twelve="$monthMembershipCount[3]" :male="$activeMaleFemaleCount['Male']"
                :female="$activeMaleFemaleCount['Female']" />
            @endcan
        </div>
    </div>
    <div>
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" id="toggleCheckbox" value="" class="sr-only peer" onchange="redirectToRoute()">
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 mr-3">Turn On</span>
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Unified Search</span>
        </label>
    </div>
</div>
@endpush

@section('main-section')
<section x-data="notes">
    <section class="w-full mt-2" x-data="{ importcsv: false }">
        {{-- filters --}}
        <div class="flex md:flex-row flex-col gap-x-4 items-center justify-between mb-4">
            <!-- Sort dropdown -->
            <div class="flex items-center md:flex-row flex-col gap-x-4 md:w-auto w-full md:gap-y-0 gap-y-3 mb-4 md:mb-0 order-2 md:order-1">
                <!-- x-filters.member-filter < /> -->
                <div class="w-full md:w-auto">
                    <x-order-by-drop-down :plans="$plans" :liabilityRange="$liabilityRange" />
                </div>
                <!-- Search Form -->
                <form action="" method="get" class="w-full">
                    <div class="flex flex-col md:flex-row items-end md:items-center gap-x-2">
                        <!-- Search Input -->
                        <div class="w-full">
                            <label for="search" class="sr-only">Search</label>
                            <input id="search" type="search"
                                class="border-0 ring-1 ring-slate-400 focus:ring-1 focus:ring-orange-600 focus:outline-none rounded-md text-sm w-full"
                                name="search" value="{{ $request->search }}" placeholder="Search by Name, Phone, ID">
                        </div>
                        <!-- Search Button -->
                        <div class="w-full md:w-auto pt-3 md:pt-0 md:text-center text-right">
                            <button type="submit" aria-label="Search" class="bg-orange-100 rounded-md text-sm py-2 px-4 border border-orange-500 text-orange-500 hover:bg-orange-200">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Action Buttons -->
            <div class="flex flex-wrap justify-end gap-4 w-full md:w-auto order-1 md:order-2 mb-6 md:mb-0">
                <x-add-button-link class="!mt-0" content="Add Member" url="{{ route(auth()->user()->roleName . 'user.create') }}" />
                <button @click="importcsv = !importcsv" type="button"
                    class="rounded-md bg-white px-6 py-2 text-sm font-semibold text-black shadow-sm border flex gap-2 items-center">
                    <svg class="size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-4m5-13v4a1 1 0 0 1-1 1H5m0 6h9m0 0-2-2m2 2-2 2"/>
</svg>


                    {{ __('Import csv') }}
                </button>
            </div>
        </div>
        {{-- Import CSV --}}
        <section x-cloak x-show="importcsv"
            class="absolute inset-0 bg-black/70 z-50 flex items-center justify-center px-2">
            <div class="bg-white w-full  md:w-1/4 p-4 rounded-md">
                <h2 class="py-2 border-b border-gray-400 px-4">{{ __('Import File') }}</h2>
                <form action="{{ route(auth()->user()->roleName . 'import.file') }}" enctype="multipart/form-data"
                    method="post" class="px-6 py-6">
                    @csrf
                    <div class="flex items-end md:items-center gap-4 flex-col md:flex-row">
                        <div class="w-full">
                            <x-input-label for="file" :value="__('Upload File')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file"
                                value="" accept=".csv" />
                        </div>
                    </div>
                    <div class="flex items-center gap-8 w-full justify-start pt-6">
                        <button type="button" @click="importcsv= !importcsv"
                            class='rounded-md bg-white px-6 py-2 text-sm font-semibold text-black shadow-sm border'>{{ __('Cancel') }}</button>
                        <x-primary-button>{{ __('Upload') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </section>
    </section>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>
                    {{ __('Profile') }} 
                </x-table-head>
                <x-table-head>
                    {{ __('Membership') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Package Amount') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Total Paid Amount') }}<br>
                    <!-- {{ __('/ Remaining Balance') }} -->
                </x-table-head>
                <x-table-head>
                    {{ __('Remaining Balance') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Notes') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Start date -') }}
                    {{ __('End date') }}
                </x-table-head>
                <!-- <x-table-head>
                                {{ __('Personal Trainer') }}
                            </x-table-head> -->
                <x-table-head>
                    {{ __('Created by') }}
                </x-table-head>
                {{-- <x-table-head>
                                            {{ __('Payment Reminder') }}
                </x-table-head> --}}
                <x-table-head>
                    {{ __('Actions') }}
                </x-table-head>
            </x-table-row>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($users as $key => $user)
            @if ($user->remaining_amount > 0.0)
            @php
            $class = 'bg-red-50';
            @endphp
            @else
            @php
            $class = '';
            @endphp
            @endif
            <x-table-row :class="$class">
                <x-table-data>
                    <span class="relative flex gap-3 flex-row items-start">
                    <span class="absolute top-0 right-0">
                        @if ($user->personalTrainer)
                        <a
                            href="{{ route(auth()->user()->roleName . 'trainers.showTrainer', ['id' => $user->id]) }}"><span
                                class="inline-block mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105">PT</span></a>
                            @endif
                    </span>
                        @if($user->image->path)
                        <a href="{{ route(auth()->user()->roleName . 'user.view', $user) }}"><img class="rounded-full w-15 h-15 object-cover hover:scale-95 cursor-pointer"
                        id="profileImage"
                        src="{{ profileImage($user->image->path) }}" alt="Profile Picture"></a>
            
                    @elseif($user->userProfile->gender == 'Male')
                    <a href="{{ route(auth()->user()->roleName . 'user.view', $user) }}" class="rounded-lg border  border-slate-200 p-1 text-slate-400 "><svg class="w-12 h-12 hover:scale-95 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor"><path d="m14.145 16.629c-.04-.527-.064-1.142-.064-1.762 0-.255.004-.51.012-.763l-.001.037c.731-.76 1.219-1.758 1.333-2.868l.002-.021c.339-.028.874-.358 1.03-1.666.016-.074.025-.16.025-.248 0-.396-.188-.747-.48-.97l-.003-.002c.552-1.66 1.698-6.796-2.121-7.326-.393-.69-1.399-1.04-2.707-1.04-5.233.096-5.864 3.951-4.72 8.366-.294.226-.482.577-.482.972 0 .088.009.174.027.257l-.001-.008c.16 1.306.691 1.638 1.03 1.666.127 1.134.628 2.133 1.374 2.888.007.214.011.466.011.718 0 .623-.023 1.24-.069 1.851l.005-.081c-1.038 2.784-8.026 2.002-8.346 7.371h22.458c-.322-5.369-7.278-4.587-8.314-7.371z"></path></svg></a>
                    @else
                    <a href="{{ route(auth()->user()->roleName . 'user.view', $user) }}"  class="rounded-lg border  border-slate-200 p-1 text-slate-400"><svg class="w-12 h-12 hover:scale-95 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor"><path d="m14.041 16.683c-.015-.168-.026-.439-.035-.72 2.549-.261 4.338-.872 4.338-1.585-.007 0-.006-.03-.006-.041-1.906-1.718 1.652-13.92-4.971-13.674-.555-.418-1.256-.669-2.015-.669-.061 0-.121.002-.181.005h.008c-8.971.678-5.004 12.203-7.049 14.378h-.004s0 0 0 0c.008.698 1.736 1.298 4.211 1.566-.007.17-.022.381-.054.734-1.027 2.77-7.962 1.994-8.282 7.323h22.294c-.319-5.33-7.225-4.554-8.253-7.317z"></path></svg></a>
                    @endif
                   <div class="flex flex-col">
                     <span class="font-extrabold">{{ $user->member_id }}</span>
                    <span>{{ $user->userProfile->fullName }} </span>
                    <span>{{ $user->phone }}</span>
                    @if ($user->exit_status)
                    <div class="inline-flex flex-col">
                        <span
                            class="inline-block mt-2 rounded-md bg-red-100 px-1 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/70 text-center">Exited
                        </span>
                    </div>
                   </div>
                    @endif
                    </span>

                </x-table-data>
               {{--   <x-table-data class="grid">


                    @if ($user->latestPlan->isPlanExpired)
                    <div class="inline-flex flex-col">
                        <span
                            class="inline-block mt-1 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/70">Plan
                            Expired
                        </span>
                        <a href="{{ route(auth()->user()->roleName . 'expired.plan.create', $user->latestPlan) }}"
                            class="inline-block mt-1 rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 ring-1 ring-inset ring-blue-600/70">
                            <span>Renew Plan</span>
                        </a>
                    </div>
                    @endif
                </x-table-data> --}}
                <x-table-data>
                    <span>{{ $user->name ?? null }}</span>
                    
                </x-table-data>
                <x-table-data>
                    <div class="flex flex-col">
                        <span class="font-semibold flex items-center gap-2 text-green-600">
                            <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor">
                                <title>money</title>
                                <path d="M59.16,11.18H12.83a5.39,5.39,0,0,0-5.22,5.56V39.18a6.77,6.77,0,0,0,1.88,4.38,5.54,5.54,0,0,0,3.34,1.26H59.16a5.47,5.47,0,0,0,5.23-5.64V16.74A5.4,5.4,0,0,0,59.16,11.18Zm1.34,21.7a12.27,12.27,0,0,0-7,7.74h-35a13,13,0,0,0-7-7.66V23A11.59,11.59,0,0,0,16,19.79a13,13,0,0,0,2.53-4.48h35a11.52,11.52,0,0,0,7,7.76v9.81Z"></path>
                                <path d="M36,18c-5.09,0-9.21,4.45-9.21,9.94s4.12,9.93,9.21,9.93,9.21-4.45,9.21-9.93S41,18,36,18Zm.75,15.62v1.86H35.09V33.79a6.25,6.25,0,0,1-2.9-.79l.5-2.14a5.68,5.68,0,0,0,2.82.8c1,0,1.63-.4,1.63-1.13s-.54-1.14-1.8-1.6c-1.82-.66-3.06-1.58-3.06-3.36a3.31,3.31,0,0,1,2.88-3.27V20.55h1.68v1.63a5.82,5.82,0,0,1,2.45.6l-.49,2.08a5.26,5.26,0,0,0-2.46-.63c-1.1,0-1.46.51-1.46,1s.59,1,2,1.58c2,.77,2.83,1.78,2.83,3.43A3.43,3.43,0,0,1,36.71,33.66Z"></path>
                            </svg>{{ $user->liabilityData()['packageAmount'] }}
                        </span>
                    </div>
                    <div class="flex flex-col mt-2 cursor-pointer">
                        @php
                        $liability = $user->liabilityData()['liability'];
                        $colorClass = $liability < 1500 ? 'text-red-600' : 'text-green-600' ;
                            @endphp

                            <span :class="$class" class="font-semibold {{ $colorClass }} flex items-center">
                            {{ __('Avg : ') }} {{ $liability }}/m
                            </span>
                    </div>

                </x-table-data>
                <x-table-data>
                    <span class="flex flex-col">{{ $user->amount ? $user->amount : $user->membershipDetails->amount }}
                    <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}"><span
                            class="inline-block mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105">{{ $user->countTransaction() }}
                            Transactions</span></a>
                    </span><br>
                    <!-- <span class="text-red-500">{{ $user->remaining_amount ? '₹' . $user->remaining_amount : $user->membershipDetails->remaining_amount }}</span> -->
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->remaining_amount ? '₹' . $user->remaining_amount : $user->membershipDetails->remaining_amount }}</span>
                </x-table-data>
                <x-table-data>
                    {{-- Notes --}}
                    <div class="flex justify-center items-center">
                        <button
                            x-on:click.prevent='$dispatch("open-modal", "userNotes"),openModal("{{ route(auth()->user()->roleName . 'members.notes.store', $user) }}",{!! json_encode($user->allNotes) !!})'>
                            <svg class="w-4 h-4 mr-2 text-orange-400" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                </path>
                            </svg>
                        </button>
                        <span>({{ $user->allNotes->count() }})</span>
                    </div>
                </x-table-data>
                <x-table-data>
                    <span class="flex flex-col items-center gap-2">
                        <span>{{ $user->start_date ? dateFormat($user->start_date) : dateFormat($user->membershipDetails->start_date) }}</span>
                        <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3"></path>
                        </svg>
                        <span>{{ $user->end_date ? dateFormat($user->end_date) : dateFormat($user->membershipDetails->end_date) }}</span>
                    </span>

                </x-table-data>
                <!-- <x-table-data>
                                        <span>{{ $user->personalTrainer ? 'Yes' : 'No' }}</span>
                                    </x-table-data> -->
                <x-table-data>
                    <span>{{ $user->createdBy->userProfile->fullName ?? '' }}</span>
                </x-table-data>
                {{-- Payment Reminder --}}
                {{-- <x-table-data>
                                                <div class="text-xs flex gap-1">
                                                    <form
                                                        action="{{ route(auth()->user()->roleName . 'payment.remainder.by.mail', $user) }}"
                method="post" class="block w-full">
                @csrf
                <button type="submit" class="flex items-center">
                    <span
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Email</span>
                </button>
                </form>
                <form
                    action="{{ route(auth()->user()->roleName . 'payment.remainder.by.sms', $user) }}"
                    method="post" class="w-full block">
                    @csrf
                    <button type="submit" class="flex items-center">
                        <span
                            class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">{{ __('SMS') }}</span>
                    </button>
                </form>
                <a href="">
                    <span
                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-800 ring-1 ring-inset ring-blue-600/20">
                        {{ __('Invioce') }}
                    </span>
                </a>
                </div>
                </x-table-data> --}}
                {{-- Action --}}
                <x-table-data class="relative">
                    <x-modal.action-modal class="-left-44">
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.membership.plan.create', $user) }}"
                                class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                <svg class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7V11H7C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13H11V17C11 17.5523 11.4477 18 12 18C12.5523 18 13 17.5523 13 17V13H17C17.5523 13 18 12.5523 18 12C18 11.4477 17.5523 11 17 11H13V7Z"
                                        fill="currentColor"></path>
                                </svg>
                                {{ __('Add membership plan') }}
                            </a>
                        </li>
                        <!-- transaction div with options view and invoice -->
                        <li x-data="{ showOptions: false }">
                            <a @click.prevent="showOptions = !showOptions"
                                class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <title>Transaction</title>
                                    <path fill="none" stroke="currentColor" stroke-width="2"
                                        d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22">
                                    </path>
                                </svg>
                                {{ __('Transactions') }}
                            </a>

                            <!-- Sliding Div for View and Invoice options -->
                            <div x-show="showOptions" @click.away="showOptions = false"
                                class="absolute left-0 top-0 mt-8 w-40 bg-white border rounded shadow-lg z-50 transition-all duration-300 transform"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-x-[-100%]"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 translate-x-[-100%]">

                                <!-- Option to view transaction -->
                                <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}"
                                    class=" px-4 py-2 hover:text-blue-600 cursor-pointer flex items-center gap-2">
                                    <svg class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4Z"
                                            fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7V11H7C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13H11V17C11 17.5523 11.4477 18 12 18C12.5523 18 13 17.5523 13 17V13H17C17.5523 13 18 12.5523 18 12C18 11.4477 17.5523 11 17 11H13V7Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <span>{{ __('Transaction') }}</span>
                                </a>
                                <!-- Option to view invoice -->
                                <a href="{{ route(auth()->user()->roleName . 'transaction.invoice.index', $user) }}"
                                    class=" px-4 py-2 hover:text-blue-600 cursor-pointer flex items-center gap-2"><svg
                                        class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z">
                                        </path>
                                    </svg>
                                    <span>{{ __(' Invoice') }}</span>
                                </a>
                            </div>
                        </li>

                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.invoice.pdf', $user) }}"
                                target=”_blank” class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z">
                                    </path>
                                </svg>
                                <span>{{ __('Invoice') }}</span>
                            </a>
                        </li>
                        {{-- <li>
                                            <a href="{{ route(auth()->user()->roleName . 'user.forgot.password', $user) }}"
                        class="cursor-pointer hover:text-yellow-500 flex items-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 15 15" fill="currentColor">
                            <path
                                d="M11 11h-1v-1h1v1zm-3 0h1v-1H8v1zm5 0h-1v-1h1v1z"
                                fill="currentColor">
                            </path>
                            <title>Forgot password</title>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3 6V3.5a3.5 3.5 0 117 0V6h1.5A1.5 1.5 0 0113 7.5v.55a2.5 2.5 0 010 4.9v.55a1.5 1.5 0 01-1.5 1.5h-10A1.5 1.5 0 010 13.5v-6A1.5 1.5 0 011.5 6H3zm1-2.5a2.5 2.5 0 015 0V6H4V3.5zM8.5 9a1.5 1.5 0 100 3h4a1.5 1.5 0 000-3h-4z"
                                fill="currentColor"></path>
                        </svg>
                        {{ __('Update Password') }}
                        </a>
                        </li> --}}
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.view', $user) }}"
                                class="cursor-pointer hover:text-blue-500  flex items-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <title>View</title>
                                    <path
                                        d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z">
                                    </path>
                                </svg>
                                {{ __('View') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.edit', $user) }}"
                                class="cursor-pointer hover:text-blue-500  flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 576 512">
                                    <title>Edit</title>
                                    <path
                                        d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                    </path>
                                </svg>
                                {{ __('Edit') }}
                            </a>
                        </li>
                        <div x-data="{ showDeleteConfirmation: false }">
                            <span>
                                <li class="flex items-center gap-1 cursor-pointer hover:text-red-600" @click="showDeleteConfirmation = !showDeleteConfirmation">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path>
                                    </svg>
                                    {{ __('Select Delete') }}
                                </li>

                                <div x-show="showDeleteConfirmation" x-transition @click.outside="showDeleteConfirmation=false" class="absolute top-28 right-10 mt-8 w-48 bg-white border shadow-md rounded-md m-5 p-2">
                                    <li>
                                        <x-delete-confirmation-modal label="Delete User" :values="$user" :message="'Are you sure you want to remove this user ?'"
                                            routename="{{ route(auth()->user()->roleName . 'user.delete', $user) }}" />
                                    </li>
                                    <li>
                                        <x-delete-confirmation-modal label="Delete Record" :values="$user->membershipDetails" :message="'Are you sure you want to remove this record ?'"
                                            routename="{{ route(auth()->user()->roleName . 'user.delete.record', $user->membershipDetails) }}" />
                                        </a>
                                    </li>
                                </div>
                            </span>
                        </div>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.exit', $user) }}"
                                class="cursor-pointer {{ $user->exit_status ? 'text-green-500' : 'text-red-500'}} flex items-center gap-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="none" stroke="currentColor">
                                    <path d="M320,176V136a40,40,0,0,0-40-40H88a40,40,0,0,0-40,40V376a40,40,0,0,0,40,40H280a40,40,0,0,0,40-40V336" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path>
                                    <polyline points="384 176 464 256 384 336" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></polyline>
                                    <line x1="191" y1="256" x2="464" y2="256" style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></line>
                                </svg>
                                {{ ($user->exit_status) ? 'Rejoin' : 'Exit' }}
                            </a>
                        </li>
                    </x-modal.action-modal>
                </x-table-data>
            </x-table-row>
            @empty
            <x-table-row>
                <x-table-data colspan="11">
                    {{ __('No Record Found') }}
                </x-table-data>
            </x-table-row>
            @endforelse
        </tbody>
    </x-table-element>
    <div class="py-3">{{ $users->links() }}</div>
    <x-modal.user-notes-modal :noteType="1" />
</section>
@endsection
@push('script')
<script>
    function changeStatus(id) {
        const form = document.getElementById(`statusForm-${id}`);
        form.submit();
    }
</script>

<script>
    function redirectToRoute() {
        const route = "{{ route(auth()->user()->roleName . 'unified.search') }}";
        const checkbox = document.getElementById('toggleCheckbox');
        if (checkbox.checked) {
            window.location.href = route;
        }
    }
</script>
@endpush