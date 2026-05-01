@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Staffs') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="mb-4 text-xl font-bold">
        <span>{{ __('Staff') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
            <a>{{ __('Staff') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full">
        <section class="flex md:flex-row flex-col md:items-center gap-4 justify-between mb-4 ">
            <!-- x-filters.staff-filter  -->
                <form action="" method="get" class="w-full order-2 sm:order-1 flex-1">
                    <div class="flex flex-row items-center gap-x-2 sm:gap-x-4 sm:justify-start justify-between mb-4 sm:mb-0">
                        <!-- Search Input -->
                        <div class="sm:w-full sm:max-w-xs flex-1 sm:flex-none">
                            <label for="search" class="sr-only">Search</label>
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
            {{-- Buttons --}}
            <div class="text-right order-1 sm:order-2">
                <x-add-button-link content="Add Staff" url="{{ route(auth()->user()->roleName . 'staff.create') }}" />
            </div>
        </section>

        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>{{ __('ID') }}</x-table-head>
                    <x-table-head>{{ __('Name') }}</x-table-head>
                    <x-table-head>{{ __('Email') }}</x-table-head>
                    <x-table-head>{{ __('Phone No.') }}</x-table-head>
                    <x-table-head>{{ __('Created By') }}</x-table-head>
                    <x-table-head>{{ __('Actions') }}</x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $key => $user)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $user->member_id }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block antialiased font-sans truncate text-sm leading-normal text-black">
                                {{ $user->userProfile->fullName }}
                            </span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block antialiased font-sans text-sm leading-normal text-black font-normal">
                                {{ $user->email }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->phone }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $user->userProfile->createdByName }}</span>
                        </x-table-data>
                        {{-- Action --}}
                        <x-table-data class="relative">
                            <x-modal.action-modal class="-left-20">
                                <li>
                                    <a href="{{ route(auth()->user()->roleName . 'staff.view', $user) }}"
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
                                </li>
                                <li>
                                    @can('isAdmin')
                                        <a href="{{ route(auth()->user()->roleName . 'staff.edit', $user) }}"
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
                                    @endcan
                                </li>
                                <li>
                                    @can('isAdmin')
                                        <x-delete-confirmation-modal label :values="$user" :message="'Are you sure you want to remove this staff member ?'"
                                            routename="{{ route(auth()->user()->roleName . 'user.delete', $user) }}" />
                                    @endcan
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
    </section>
@endsection
