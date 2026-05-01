@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Expired Plan') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Expired Plan') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Expired Plan') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2" x-data="notes">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:w-1/2">
            <!-- x-filters.expired-plan-filter  -->
            <x-expired-plan-drop-down />
            <form action="" method="get" class="w-full py-2">
                    <div class="flex flex-col md:flex-row items-end md:items-center">
                        <!-- Search Input -->
                        <div class="w-fit">
                            <label for="search" class="sr-only">Search</label>
                            <input id="search" type="search"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-2 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
                                name="search" value="{{ $request->search }}" placeholder="Search name...">
                        </div>
                        <!-- Search Button -->
                        <div class="w-full md:w-auto pt-3 md:pt-0 text-center">
                            <button type="submit" aria-label="Search" class="p-2 hover:scale-110">
                                <svg class="h-7 w-7 text-black hover:text-orange-600" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
        </div>
        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>
                        {{ __('ID') }}
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
                        {{ __('Interest Status') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Amount') }}
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
                    {{-- <x-table-head>
                                        {{ __('Payment Reminder') }}
                                    </x-table-head> --}}
                    <x-table-head>
                        {{ __('Actions') }}
                    </x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($plans as $key => $plan)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $plan->user->member_id }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block antialiased font-sans truncate text-sm leading-normal text-blue-gray-900">
                                {{ $plan->userProfile->fullName }}
                            </span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->user->phone }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->name ?? null }}</span>
                        </x-table-data>
                        <x-table-data>
                    @if ($plan->interest_status==2)
                    <span class="flex flex-row justify-center items-center gap-1 text-red-500 font-semibold"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 428 480" fill="currentColor"><title>cancel</title><path d="M90 390l120-120 130 120 30-30-130-120 130-120-30-30-130 120-120-120-30 30 120 120-120 120 30 30z"></path></svg>
                        Not Interested</span>
                    @else
                    <span class="flex flex-row justify-center items-center gap-1 text-green-500"><svg class="w-6 h-6 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                            <path d="M9.9973 2.70682C10.0395 3.11887 9.73971 3.48714 9.32765 3.52936C6.05087 3.8651 3.49414 6.63471 3.49414 10.0005C3.49414 13.5933 6.4067 16.5059 9.99952 16.5059C13.365 16.5059 16.1343 13.9498 16.4706 10.6735C16.5129 10.2615 16.8812 9.96171 17.2932 10.004C17.7053 10.0463 18.005 10.4146 17.9627 10.8267C17.5488 14.8601 14.142 18.0059 9.99952 18.0059C5.57827 18.0059 1.99414 14.4218 1.99414 10.0005C1.99414 5.85759 5.14064 2.45051 9.17476 2.03717C9.58681 1.99495 9.95508 2.29476 9.9973 2.70682ZM11.0176 2.6409C11.114 2.23806 11.5187 1.98966 11.9216 2.08608C12.3004 2.17674 12.6688 2.29397 13.0249 2.43568C13.4097 2.58885 13.5976 3.025 13.4444 3.40986C13.2912 3.79471 12.8551 3.98253 12.4702 3.82936C12.1805 3.71404 11.8807 3.61865 11.5724 3.54488C11.1696 3.44846 10.9212 3.04374 11.0176 2.6409ZM17.5637 6.97359C17.4104 6.58876 16.9743 6.40103 16.5894 6.55427C16.2046 6.70751 16.0169 7.14369 16.1701 7.52852C16.2855 7.81839 16.381 8.11835 16.4549 8.42673C16.5513 8.82956 16.9561 9.07792 17.3589 8.98146C17.7617 8.885 18.0101 8.48025 17.9136 8.07742C17.8229 7.69845 17.7055 7.3298 17.5637 6.97359ZM14.2899 3.92629C14.5618 3.6138 15.0355 3.58089 15.348 3.85278C15.6552 4.12001 15.942 4.41 16.2059 4.72013C16.4743 5.0356 16.4361 5.50894 16.1207 5.77736C15.8052 6.04578 15.3318 6.00764 15.0634 5.69217C14.8481 5.43911 14.6141 5.20247 14.3634 4.9844C14.0509 4.71251 14.018 4.23878 14.2899 3.92629ZM9.99976 5.75024C9.99976 5.33603 9.66397 5.00024 9.24976 5.00024C8.83554 5.00024 8.49976 5.33603 8.49976 5.75024V10.7502C8.49976 11.1645 8.83554 11.5002 9.24976 11.5002H12.2498C12.664 11.5002 12.9998 11.1645 12.9998 10.7502C12.9998 10.336 12.664 10.0002 12.2498 10.0002H9.99976V5.75024Z" fill="currentColor"></path>
                        </svg>Interested</span>
                    @endif
                </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->amount ? '₹' . $plan->amount : '₹ 0.0' }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->remaining_amount ? '₹' . $plan->remaining_amount : '₹ 0.0' }}</span>
                        </x-table-data>
                        <x-table-data>
                            {{-- Notes --}}
                            <div class="flex justify-center items-center">
                                <button
                                    x-on:click.prevent='$dispatch("open-modal", "userNotes"),openModal("{{ route(auth()->user()->roleName . 'members.notes.store', $plan->user) }}",{!! json_encode($plan->user->allNotes) !!})'>
                                    <svg class="w-4 h-4 mr-2 text-orange-400" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                        </path>
                                    </svg>
                                </button>
                                <span>({{ $plan->user->allNotes->count() }})</span>
                            </div>
                        </x-table-data>
                        <x-table-data>
                            <!-- {{ dateFormat($plan->next_follow_up_date) }} -->
                            {{ $plan->user->expiredPlanNotes->isNotEmpty() ? dateFormat($plan->user->expiredPlanNotes->first()->next_follow_up_date) : 'Null' }}
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($plan->start_date) }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($plan->end_date) }}</span>
                        </x-table-data>
                        {{-- Payment Reminder --}}
                        {{-- <x-table-data>
                                            <div class=" text-xs flex gap-1">
                                                <form
                                                    action="{{ route(auth()->user()->roleName . 'payment.remainder.by.mail', $plan->user) }}"
                                                    method="post" class="block w-full">
                                                    @csrf
                                                    <button type="submit" class="flex items-center">
                                                        <span
                                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Email</span>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route(auth()->user()->roleName . 'payment.remainder.by.sms', $plan->user) }}"
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
                        <x-table-data class="flex flex-col gap-2 justify-center items-center">
                            <a href="{{ route(auth()->user()->roleName . 'expired.plan.create', $plan) }}"
                                class="cursor-pointer">
                                <span
                                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Renew
                                    Plan</span>
                            </a>
                            @if ($plan->interest_status!=2)
                        <span class="flex flex-col gap-3">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route(auth()->user()->roleName . 'upcoming.renewal.update', $plan) }}"
                                    class="cursor-pointer">
                                    <span
                                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Not Interested</span>
                                </a>
                            </div>
                        </span>
                        @endif
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
        <div class="py-3">{{ $plans->links() }}</div>
        <x-modal.user-notes-modal :noteType="3" />
    </section>
@endsection
