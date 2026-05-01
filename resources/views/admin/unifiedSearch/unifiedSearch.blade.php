@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Unifed Search') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')

<!-- Breadcrum -->
<div class="flex gap-4 items-center justify-between">
    <div class="py-2 text-xl font-bold flex flex-row items-center">
        <div>
            <span>{{ __('Unified Search') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a>{{ __('Unified Search') }}</a>
            </span>
        </div>

    </div>
</div>
@endpush

@php
$role_status = $members;
@endphp

@section('main-section')
<section x-data="notes">
    <section class="w-full mt-2" x-data="{ importcsv: false }">
        {{-- filters --}}
        <div class="md:flex-row flex-col gap-x-4 items-center justify-between mb-4">
            <!-- Sort dropdown -->
            <div class="flex justify-between items-center md:flex-row flex-col gap-x-4 md:w-auto w-full md:gap-y-0 gap-y-3 mb-4 md:mb-0 order-2 md:order-1">
                <!-- Search Form -->
                <form action="" method="get" class="w-1/2">
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
                <div>
                <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" id="toggleCheckbox" value="" class="sr-only peer" onchange="redirectToRoute()" checked>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 mr-3">Turn Off</span>
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Unified Search</span>
        </label>
                </div>
            </div>
        </div>
    </section>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>
                    {{ __('Member Id / Lead Id') }}
                </x-table-head>
                <!-- <x-table-head>
                    {{ __('Info') }}
                </x-table-head> -->
                <x-table-head>
                    {{ __('Name') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Email') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Membership / Membership Intrested') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Total Paid Amount / Amount Offered') }}<br>
                    <!-- {{ __('/ Remaining Balance') }} -->
                </x-table-head>
                <x-table-head>
                    {{ __('Remaining Balance') }}
                </x-table-head>
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
            @forelse ($members as $key => $user)
            @if ($user->deleted_at != null)
            @php
            $class = 'bg-red-100';
            @endphp
            @else
            @php
            $class = '';
            @endphp
            @endif
            <x-table-row :class="$class">
                <x-table-data class="flex-col items-center gap-10">
                    <!-- <span class="block">{{ $key + 1 }}</span> -->
                    @php
                    if($user->role_id == 1){
                    $role='Admin';
                    }elseif($user->role_id == 2){
                    $role='Staff';
                    }elseif($user->role_id == 3){
                    $role='Member';
                    }elseif($user->role_id == 4){
                    $role='Trainer';
                    }
                    @endphp
                    @if ($user->deleted_at != null)
                    <span class="inline-block mt-1 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/70">{{ 'Deleted Member' }}</span>
                    @else
                    <span class="inline-block mt-1 rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800 ring-1 ring-inset ring-blue-600/70">{{ $user->member_id ? $role.' : '.$user->member_id : 'Lead : '.$user->id }}
                    </span>
                    @endif
                </x-table-data>
                <x-table-data>
                    <span class="flex flex-col justify-center">
                        <span class="block antialiased font-sans truncate text-sm leading-normal text-blue-gray-900">
                            {{ $user->userProfile->fullName ?? $user->first_name . ' ' . $user->last_name }}
                        </span>
                        <span>{{ $user->phone }}</span>
                        <span class="block">{{ $user->userProfile->gender ?? $user->gender}}</span>
                    </span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->email ?? 'N/A' }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->membershipDetails->name ?? $user->membership_interested }}</span><br>
                    @if ($user?->latestPlan?->isPlanExpired)
                    <span class="inline-block mt-1 rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/70">{{ __('Plan Expired') }}</span>
                    @endif
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->amount ? $user->amount : $user->membershipDetails->amount ?? $user->amount_offer }}</span><br>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->remaining_amount ? '₹' . $user->remaining_amount : $user->membershipDetails->remaining_amount ?? 'N/A' }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->createdBy->userProfile->fullName ?? '' }}</span>
                </x-table-data>
                {{-- Action --}}
                <x-table-data class="relative">
                    <!--  -->
                    @php
                    if($user->role_id == 2){
                    $go_to = 'staff.view';
                    }elseif($user->role_id == 3){
                    $go_to = 'user.view';
                    }elseif($user->role_id == 4){
                    $go_to = 'trainers.view';
                    }
                    else{
                    $go_to = 'lead.view';}
                    @endphp
                    <!--  -->
                    @if ($user->deleted_at == null)
                    @if($user->role_id == 1)
                    <a href="{{ route(auth()->user()->roleName .'profile.edit') }}">
                        @else
                        <a href="{{ route(auth()->user()->roleName .$go_to, $user) }}">
                            @endif
                            <svg class="w-8 h-8 hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        @else
                        <svg class="w-9 h-9 text-red-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"></path>
                        </svg>
                        @endif
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
    <div class="py-3">{{ $members->links() }}</div>
    <x-modal.user-notes-modal :noteType="1" />
</section>
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
        const route = "{{ route(auth()->user()->roleName . 'user.index') }}";
        const checkbox = document.getElementById('toggleCheckbox');

        if (!checkbox.checked) {
            window.location.href = route;
        }
    }
</script>
@endpush