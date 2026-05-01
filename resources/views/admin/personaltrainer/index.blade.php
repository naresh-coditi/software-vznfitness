@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Personal Trianing') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
<div class="mb-4  text-xl font-bold">
    <span>{{ __('Personal Training') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a>{{ __('Personal Training') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<section class="w-full" x-data="notes">
    {{-- Buttons --}}
    <div class="flex md:flex-row flex-col md:items-center gap-4 justify-between mb-4 ">
        <!-- x-filters.manage-pt-filter  -->
        <form action="" method="get" class="w-full order-2 sm:order-1 flex-1">
            <div class="flex flex-row items-center gap-x-2 sm:gap-x-4 sm:justify-start justify-between mb-4 sm:mb-0">
                <!-- Search Input -->
                <div class="sm:w-full sm:max-w-xs flex-1 sm:flex-none">
                    <input id="search" type="search"
                        class="border-0 ring-1 ring-slate-400 focus:ring-1 focus:ring-orange-600 focus:outline-none rounded-md text-sm w-full"
                        name="search" value="{{ $request->search }}" placeholder="Search name...">
                </div>
                <!-- Search Button -->
                <div class="sm:w-full md:w-auto  md:pt-0 md:text-center text-left flex-none">
                    <button type="submit" aria-label="Search" class="bg-orange-100 rounded-md text-sm py-2 px-4 border border-orange-500 text-orange-500 hover:bg-orange-200">
                        Search
                    </button>
                </div>
            </div>
        </form>
        <div class="text-right order-1 sm:order-2">
            <x-add-button-link content="ADD" url="{{ route(auth()->user()->roleName . 'pt.create') }}" />
        </div>
    </div>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>
                    {{ __('Sr No.') }}
                </x-table-head>
                <x-table-head>
                    {{ __('ID') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Member Name') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Phone No.') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Trianer Name') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Payment Method') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Amount') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Remaining Balance') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Note') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Duration') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Start Date') }}
                </x-table-head>
                <x-table-head>
                    {{ __('End Date') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Actions') }}
                </x-table-head>
            </x-table-row>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($users as $key => $user)
            @php
            if ($user->latestPersonalTrainerPlan->end_date < today()) {
                $class='bg-red-50' ;
                } else {
                $class='' ;
                }
                @endphp
                <x-table-row :class="$class">
                <x-table-data>
                    <span>{{ $key + $users->firstItem() }}</span>
                </x-table-data>
                <x-table-data>
                    <span class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                        {{ $user->member_id }}
                    </span>
                </x-table-data>
                <x-table-data>
                    <span class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                        {{ $user->userProfile->fullName }}</span>
                    <a href="{{ route(auth()->user()->roleName . 'pt.transactions.index', $user) }}">
                        <span class="inline-block mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105">{{$user->countTransaction().' transactions'}}</span>
                    </a>


                </x-table-data>
                <x-table-data>
                    <span class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                        {{ $user->phone }}
                    </span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->latestPersonalTrainerPlan->trainer }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->latestPersonalTrainerPlan->method_type }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->latestPersonalTrainerPlan->amount }}</span>
                </x-table-data>
                <x-table-data>
                    <!-- remaining balance -->
                    <span>{{ $user->latestPersonalTrainerPlan->remaining_balance }}</span>

                </x-table-data>
                <x-table-data>
                    {{-- Notes --}}
                    <div class="flex justify-center items-center">
                        <button
                            x-on:click.prevent='$dispatch("open-modal", "userNotes"),openModal("{{ route(auth()->user()->roleName . 'members.notes.store', $user) }}",{!! json_encode($user->PersonalTrainerNotes) !!})'>
                            <svg class="w-4 h-4 mr-2 text-orange-400" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                </path>
                            </svg>
                        </button>
                        <span>({{ $user->PersonalTrainerNotes->count() }})</span>
                    </div>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->latestPersonalTrainerPlan->duration }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ dateformat($user->latestPersonalTrainerPlan->start_date) }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ dateformat($user->latestPersonalTrainerPlan->end_date) }}</span>
                </x-table-data>
                {{-- Action --}}
                <x-table-data class="relative">
                    <x-modal.action-modal class="-left-32">
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'pt.plan.index', $user) }}"
                                class="flex items-center gap-2 hover:text-blue-500">
                                <svg class="w-4 h-4" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <title>Add Plan</title>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7V11H7C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13H11V17C11 17.5523 11.4477 18 12 18C12.5523 18 13 17.5523 13 17V13H17C17.5523 13 18 12.5523 18 12C18 11.4477 17.5523 11 17 11H13V7Z"
                                        fill="currentColor"></path>
                                </svg>
                                <span>
                                    Add Plan
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'pt.transactions.index', $user) }}"
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
                        </li>
                        <li>
                                <a href="{{ route(auth()->user()->roleName . 'pt.invoice.pdf', $user) }}"
                                    class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z">
                                        </path>
                                    </svg>
                                    <span>{{ __('Invoice') }}</span>
                                </a>
                            </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'pt.edit', $user->latestPersonalTrainerPlan) }}"
                                class="flex items-center gap-2 hover:text-blue-500">
                                <span>
                                    <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 576 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                                        <title>Edit</title>
                                        <path
                                            d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                        </path>
                                    </svg>
                                </span>
                                <span>Edit</span>
                            </a>
                        </li>
                        <li>
                            <x-delete-confirmation-modal label :values="$user" :message="'Are you sure you want to remove this record ?'"
                                routename="{{ route(auth()->user()->roleName . 'pt.delete', $user->latestPersonalTrainerPlan) }}" />
                        </li>
                    </x-modal.action-modal>
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
    <div class="py-3">{{ $users->links() }}</div>
    <x-modal.user-notes-modal :noteType="5" />
</section>
@endsection