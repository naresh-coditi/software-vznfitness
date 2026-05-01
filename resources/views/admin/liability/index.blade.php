@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' liabilities') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')

<!-- Breadcrum -->
<div class="flex gap-4 items-center justify-between">
    <div class="py-2 text-xl font-bold flex flex-row items-center">
        <div>
            <span>{{ __('Liabilities') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a>{{ __('Liabilities') }}</a>
            </span>
        </div>
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
                <div class="w-full md:w-auto">
                    <x-liability-drop-down :liabilityRange="$liabilityRange" />
                </div>
                <!-- Search Form -->
                <form action="" method="get" class="w-full mt-4">
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
    </section>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head class="text-center">
                    {{ __('Profile') }}
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Membership') }}
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Package Amount') }}
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Liability') }}
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Total Paid Amount') }}<br>
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Remaining Balance') }}
                </x-table-head>
                <x-table-head class="text-center">
                    {{ __('Start date -') }}
                    {{ __('End date') }}
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
                <x-table-data class="grid">
                <span class="flex flex-col items-center">
                        @if($user->image->path)
                    <img class="rounded-full w-16 h-16 object-cover"
                        id="profileImage"
                        src="{{ profileImage($user->image->path) }}" alt="Profile Picture">
                    @elseif($user->userProfile->gender == 'Male')
                    <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor"><path d="m14.145 16.629c-.04-.527-.064-1.142-.064-1.762 0-.255.004-.51.012-.763l-.001.037c.731-.76 1.219-1.758 1.333-2.868l.002-.021c.339-.028.874-.358 1.03-1.666.016-.074.025-.16.025-.248 0-.396-.188-.747-.48-.97l-.003-.002c.552-1.66 1.698-6.796-2.121-7.326-.393-.69-1.399-1.04-2.707-1.04-5.233.096-5.864 3.951-4.72 8.366-.294.226-.482.577-.482.972 0 .088.009.174.027.257l-.001-.008c.16 1.306.691 1.638 1.03 1.666.127 1.134.628 2.133 1.374 2.888.007.214.011.466.011.718 0 .623-.023 1.24-.069 1.851l.005-.081c-1.038 2.784-8.026 2.002-8.346 7.371h22.458c-.322-5.369-7.278-4.587-8.314-7.371z"></path></svg>
                    @else
                    <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 24" fill="currentColor"><path d="m14.041 16.683c-.015-.168-.026-.439-.035-.72 2.549-.261 4.338-.872 4.338-1.585-.007 0-.006-.03-.006-.041-1.906-1.718 1.652-13.92-4.971-13.674-.555-.418-1.256-.669-2.015-.669-.061 0-.121.002-.181.005h.008c-8.971.678-5.004 12.203-7.049 14.378h-.004s0 0 0 0c.008.698 1.736 1.298 4.211 1.566-.007.17-.022.381-.054.734-1.027 2.77-7.962 1.994-8.282 7.323h22.294c-.319-5.33-7.225-4.554-8.253-7.317z"></path></svg>
                    @endif
                    <span class="font-extrabold">{{ $user->member_id }}</span>
                    <span>{{ $user->userProfile->fullName }} </span>
                    <span>{{ $user->phone }}</span>
                    </span>
                </x-table-data>
                <x-table-data>
                    <span class="flex flex-col items-center">{{ $user->name ?? null }}
                    <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}"><span
                            class="inline-block mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105">{{ $user->countTransaction() }}
                            Transactions</span></a></span>
                </x-table-data>
                <x-table-data>
                    <div class="flex flex-col items-center">
                        <span class="font-semibold flex items-center gap-2 text-green-600">
                            <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor">
                                <title>money</title>
                                <path d="M59.16,11.18H12.83a5.39,5.39,0,0,0-5.22,5.56V39.18a6.77,6.77,0,0,0,1.88,4.38,5.54,5.54,0,0,0,3.34,1.26H59.16a5.47,5.47,0,0,0,5.23-5.64V16.74A5.4,5.4,0,0,0,59.16,11.18Zm1.34,21.7a12.27,12.27,0,0,0-7,7.74h-35a13,13,0,0,0-7-7.66V23A11.59,11.59,0,0,0,16,19.79a13,13,0,0,0,2.53-4.48h35a11.52,11.52,0,0,0,7,7.76v9.81Z"></path>
                                <path d="M36,18c-5.09,0-9.21,4.45-9.21,9.94s4.12,9.93,9.21,9.93,9.21-4.45,9.21-9.93S41,18,36,18Zm.75,15.62v1.86H35.09V33.79a6.25,6.25,0,0,1-2.9-.79l.5-2.14a5.68,5.68,0,0,0,2.82.8c1,0,1.63-.4,1.63-1.13s-.54-1.14-1.8-1.6c-1.82-.66-3.06-1.58-3.06-3.36a3.31,3.31,0,0,1,2.88-3.27V20.55h1.68v1.63a5.82,5.82,0,0,1,2.45.6l-.49,2.08a5.26,5.26,0,0,0-2.46-.63c-1.1,0-1.46.51-1.46,1s.59,1,2,1.58c2,.77,2.83,1.78,2.83,3.43A3.43,3.43,0,0,1,36.71,33.66Z"></path>
                            </svg>{{ $user->liabilityData()['packageAmount'] }}
                        </span>
                    </div>
                </x-table-data>
                <x-table-data>
                    <div class="flex flex-col items-center mt-2 cursor-pointer">
                        @php
                        $liability = $user->liabilityData()['liability'];
                        $colorClass = $liability < 1500 ? 'text-red-600' : 'text-blue-600' ;
                            @endphp

                            <span class="font-semibold {{ $colorClass }} flex items-center">
                            ₹ {{ number_format($liability) }}/m
                            </span>
                    </div>

                </x-table-data>
                <x-table-data>
                    <span class="flex justify-center">{{ $user->amount ? $user->amount : $user->membershipDetails->amount }}</span><br>
                </x-table-data>
                <x-table-data>
                    <span class="flex justify-center">{{ $user->remaining_amount ? '₹' . $user->remaining_amount : $user->membershipDetails->remaining_amount }}</span>
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