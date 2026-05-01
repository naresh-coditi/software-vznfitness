@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Members') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="mb-4 text-xl font-bold">
        <span>{{ __('Deleted Members') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Deleted Members') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section x-data="notes">
        <section class="w-full" x-data="{ importcsv: false }">
            {{-- filters --}}
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
                            {{ __('Membership') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Total Paid Amount') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Remaining Balance') }}
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
                        @if ($user->latestPlan->remaining_amount > 0.0)
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
                                <span class="block">{{ $user->member_id }}</span>
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
                            </x-table-data>
                            <x-table-data>
                                <span
                                    class="block antialiased font-sans truncate text-sm leading-normal text-blue-gray-900">
                                    {{ $user->userProfile->fullName }}
                                </span>
                                <span>{{ $user->phone }}</span>
                                <span class="block">{{ $user->userProfile->gender }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->latestPlan->name ?? null }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->latestPlan->amount ? '₹' . $user->latestPlan->amount : '₹ 0.0' }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->latestPlan->remaining_amount ? '₹' . $user->latestPlan->remaining_amount : '₹ 0.0' }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ dateFormat($user->latestPlan->start_date) }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ dateFormat($user->latestPlan->end_date) }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->personalTrainer ? 'Yes' : 'No' }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $user->createdBy->userProfile->fullName ?? '' }}</span>
                            </x-table-data>
                            {{-- Action --}}
                            <x-table-data class="relative">
                                <x-modal.action-modal class="-left-32">
                                    <li>
                                        <form
                                            action="{{ route(auth()->user()->roleName . 'deleted.member.update', ['user' => $user]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
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
                                                {{ __('Restore') }}
                                            </button>
                                        </form>
                                    </li>
                                    {{-- <li>
                                        <x-delete-confirmation-modal label :values="$user" :message="'Are you sure you want to remove this user ?'"
                                            routename="{{ route(auth()->user()->roleName . 'deleted.member.delete', ['user' => $user]) }}" />
                                    </li> --}}
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
        </section>
    </section>
@endsection
