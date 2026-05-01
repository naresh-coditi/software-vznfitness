@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __('Remaining Balance') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Remaining Balance') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Remaining Balance') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2" x-data="notes">

        <div class="py-4">
            <!--  -->
            <p class="text-gray-800 text-base">
                <span class="font-semibold text-lg">Total Remaining Balance: </span>
                <span class="text-orange-600">{{ $totalRemainingBalance }}</span>
            </p>
            <!--  -->
        </div>
        {{-- filters --}}
        <section class="flex flex-row items-center gap-10">
        <!-- x-filters.remaining-balance-filter  -->
            <x-remaining-blanace-drop-down />
             <!-- Search Form -->
         <form action="" method="get" class="w-full md:w-[30%] py-2">
                <div class="flex flex-col md:flex-row items-end md:items-center">
                    <!-- Search Input -->
                    <div class="w-full md:w-w[50%]">
                        <label for="search" class="sr-only">Search</label>
                        <input id="search" type="search"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
                            name="search" value="{{ $request->search }}" placeholder="Search by Name, Phone, ID">
                    </div>
                    <!-- Search Button -->
                    <div class="w-full md:w-auto pt-3 md:pt-0 text-center">
                        <button type="submit" aria-label="Search"
                            class="p-2 hover:scale-110">
                            <svg class="h-7 w-7 text-black hover:text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>
                        {{ __('Id') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Name') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Phone No.') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Membership') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Total Paid Amount') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Remaining Balance') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Notes') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Follow Up Date') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Start date') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('End date') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Personal Trainer') }}
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
                @forelse ($users as $key => $user)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $user->member_id }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block antialiased font-sans truncate text-sm leading-normal text-blue-gray-900">
                                {{ $user->userProfile->fullName }}
                            </span>
                            <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}"><span class="inline-block mt-1 rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/70 hover:scale-105">{{$user->countTransaction()}} Transactions</span></a>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->phone }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->name ?? null }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->amount ? '₹' . $user->amount : '₹ 0.0' }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->remaining_amount ? '₹' . $user->remaining_amount : '₹ 0.0' }}</span>
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
                            <!--  -->
                        </x-table-data>
                        <x-table-data>
                            <span>
                                {{ dateFormat($user->next_follow_up_date) }}
                                <!-- {{ $user->remainingBalanceNotes->isNotEmpty() ? dateFormat($user->remainingBalanceNotes->first()->next_follow_up_date) : 'Null' }} -->
                            </span>

                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($user->start_date) }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($user->end_date) }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->personalTrainer ? 'Yes' : 'No' }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->createdBy->userProfile->fullName ?? '' }}</span>
                        </x-table-data>
                        {{-- Payment Reminder --}}
                        {{-- <x-table-data>
                                <div class=" text-xs flex gap-1">
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
                                </div>
                            </x-table-data> --}}
                        {{-- Action --}}
                        <x-table-data class="relative">
                            <x-modal.action-modal class="-left-28">
                                <li>
                                    <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}"
                                        class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <title>Transaction</title>
                                            <path fill="none" stroke="currentColor" stroke-width="2"
                                                d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22">
                                            </path>
                                        </svg>
                                        <span>Transaction</span>
                                    </a>
                                </li>
                                {{-- <li>
                                            <a href="{{ route(auth()->user()->roleName . 'user.forgot.password', $user) }}"
                                                class="cursor-pointer hover:text-yellow-500">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 15 15" fill="currentColor">
                                                    <path d="M11 11h-1v-1h1v1zm-3 0h1v-1H8v1zm5 0h-1v-1h1v1z"
                                                        fill="currentColor">
                                                    </path>
                                                    <title>Forgot password</title>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M3 6V3.5a3.5 3.5 0 117 0V6h1.5A1.5 1.5 0 0113 7.5v.55a2.5 2.5 0 010 4.9v.55a1.5 1.5 0 01-1.5 1.5h-10A1.5 1.5 0 010 13.5v-6A1.5 1.5 0 011.5 6H3zm1-2.5a2.5 2.5 0 015 0V6H4V3.5zM8.5 9a1.5 1.5 0 100 3h4a1.5 1.5 0 000-3h-4z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <span>Forgot password</span>
                                            </a>
                                        </li> --}}
                                <!-- <li>
                                                    <a href="{{ route(auth()->user()->roleName . 'user.view', $user) }}"
                                                        class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <title>View</title>
                                                            <path
                                                                d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z">
                                                            </path>
                                                        </svg>
                                                        <span>View</span>
                                                    </a>
                                                </li> -->
                                <li>
                                    <a href="{{ route(auth()->user()->roleName . 'user.edit', $user) }}"
                                        class="cursor-pointer hover:text-blue-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 576 512">
                                            <title>Edit</title>
                                            <path
                                                d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                            </path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <x-delete-confirmation-modal label :values="$user" :message="'Are you sure you want to remove this user ?'"
                                        routename="{{ route(auth()->user()->roleName . 'user.delete', $user) }}" />
                                </li>
                            </x-modal.action-modal>
                        </x-table-data>
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="10">
                            {{ __('No Record Found') }}
                        </x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
        <div class="py-3">{{ $users->links() }}</div>
        <x-modal.user-notes-modal :noteType="4" />
    </section>
@endsection
@push('script')
    <script>
        function changeStatus(id) {
            const form = document.getElementById(`statusForm-${id}`);
            form.submit();
        }
    </script>
@endpush
