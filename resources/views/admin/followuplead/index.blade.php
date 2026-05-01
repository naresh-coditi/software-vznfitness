@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Leads') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
<div class="pl-6 py-2 mt-10  text-xl font-bold">
    <span>{{ __('Follow Up Leads') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a>{{ __('Follow Up Leads') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<section class="w-full px-6 mt-2 py-2" x-data="notes">
    <section class="flex flex-col md:flex-row items-center">
        <!-- x-filters.follow-up-lead-filter  -->
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
    </section>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>
                    {{ __('Sr No.') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Approach Status') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Name') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Phone No.') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Lead Dead') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Membership Interested') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Note') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Previous Follow Up Date') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Latest Follow Up Date') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Created By') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Actions') }}
                </x-table-head>
            </x-table-row>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($users as $key => $user)
            @if($user->approach_status==1)
            @php
            $class = 'bg-green-50';
            @endphp
            @else
            @php
            $class= ' ';
            @endphp
            @endif
            <x-table-row :class="$class">
                <x-table-data>
                    <span>{{ $key + $users->firstItem() }}</span>
                </x-table-data>
                <x-table-data>
                    <span>
                        @if ($user->approach_status==0)
                        <div class="flex flex-row justify-start items-center gap-2">
                            <svg class="w-6 h-6 text-red-500" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="currentColor">
                                <g>
                                    <rect fill="none" height="24" width="24"></rect>
                                    <path d="M17,12c-2.76,0-5,2.24-5,5s2.24,5,5,5c2.76,0,5-2.24,5-5S19.76,12,17,12z M18.65,19.35l-2.15-2.15V14h1v2.79l1.85,1.85 L18.65,19.35z M18,3h-3.18C14.4,1.84,13.3,1,12,1S9.6,1.84,9.18,3H6C4.9,3,4,3.9,4,5v15c0,1.1,0.9,2,2,2h6.11 c-0.59-0.57-1.07-1.25-1.42-2H6V5h2v3h8V5h2v5.08c0.71,0.1,1.38,0.31,2,0.6V5C20,3.9,19.1,3,18,3z M12,5c-0.55,0-1-0.45-1-1 c0-0.55,0.45-1,1-1c0.55,0,1,0.45,1,1C13,4.55,12.55,5,12,5z"></path>
                                </g>
                            </svg>
                            <span class="text-red-500 text-md font-semibold">Pending</span>
                        </div>

                        @elseif($user->approach_status==1)
                        <div class="flex flex-row justify-start items-center gap-2">
                            <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                            </svg>
                            <span class="text-green-500 text-md font-semibold">Done</span>
                        </div>

                        @endif
                        <!-- {{($user->approach_status==0) ? "Pending" : "Done"}} -->
                    </span>
                </x-table-data>
                <x-table-data>
                    <span class="block font-sans text-sm leading-normal text-blue-gray-900">
                        {{ $user->first_name . ' ' . $user->last_name }}
                    </span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->phone }}</span>
                </x-table-data>
                <x-table-data>
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" name="status" id="statusModal-{{ $key }}"
                            data-url="{{ route(auth()->user()->roleName . 'lead.status.update', $user) }}"
                            class="sr-only peer" data-on="Active" data-off="InActive"
                            {{ $user->status ? 'checked' : '' }} data-status={{ $user->status }}
                            onchange="changeStatus(event)">
                        <div
                            class="w-11 h-6 bg-red-600 peer-focus:outline-none
                                    peer-focus:ring-4 peer-focus:ring-blue-300
                                    rounded-full peer peer-checked:after:translate-x-full
                                    peer-checked:after:border-white after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-blue-600">
                        </div>
                        <p class="ml-3">
                            {{ $user->status ? 'Activated' : 'Deactivated' }}
                        </p>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->membership_interested }}</span>
                </x-table-data>
                <x-table-data>
                    <div class="flex justify-center items-center">
                        <button
                            x-on:click.prevent='$dispatch("open-modal", "leadNotes"),openModal("{{ route(auth()->user()->roleName . 'lead.notes.store', $user) }}",{!! json_encode($user->notes) !!})'>
                            <svg class="w-4 h-4 mr-2 text-orange-400" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                </path>
                            </svg>
                        </button>
                        <span>({{ $user->notes->count() }})</span>
                        {{-- <button @click="notes=@js($user->notes),open = true">
                                        <a href="{{ route(auth()->user()->roleName . 'lead.notes.index', $user) }}"
                        class="flex items-center gap-0">
                        <p>
                            <svg class="w-4 h-4 mr-2 {{ $user->notes->count() > 0 ? 'text-orange-400' : 'text-gray-400 cursor-not-allowed' }}"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                </path>
                            </svg>
                        </p>
                        </a>
                        <a href="{{ route(auth()->user()->roleName . 'lead.notes.index', $user) }}">
                            <svg class="w-4 h-4 cursor-pointer text-orange-600 hover:text-orange-500"
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2
                                                                                                                                                                                                0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1
                                                                                                                                                                                                0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z">
                                </path>
                            </svg>
                        </a>
                        </button> --}}
                    </div>
                </x-table-data>
                <x-table-data>
                    <span>{{ dateFormat($user->previousFollowUpDate()->next_follow_up_date ?? $user->follow_up_date) }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ dateFormat($user->follow_up_date) }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->createdByProfile->fullName }}</span>
                </x-table-data>
                {{-- Action --}}
                <x-table-data class="relative">
                    <x-modal.action-modal class="-left-40">
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'user.create', $user) }}"
                                class="flex items-center gap-2 hover:text-blue-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <title>Convert lead to member</title>
                                    <path
                                        d="M14 14.252V22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM18 17V13.5L23 18L18 22.5V19H15V17H18Z">
                                    </path>
                                </svg>
                                <span>Convert to Member</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'followup.lead.check', $user) }}"
                                class="flex items-center gap-2 hover:text-blue-500">
                                <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"></path>
                                </svg>
                                <span>Done with this follow up</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->roleName . 'lead.view', $user) }}"
                                class="flex items-center gap-2 hover:text-blue-500">
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
                            <a href="{{ route(auth()->user()->roleName . 'lead.edit', $user) }}"
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
                            {{-- Delete Confirmation Modal  --}}
                            <x-delete-confirmation-modal label :values="$user" :message="'Are you sure you want to remove this lead ?'"
                                routename="{{ route(auth()->user()->roleName . 'lead.delete', $user) }}" />
                        </li>
                    </x-modal.action-modal>
                </x-table-data>
            </x-table-row>
            @empty
            <x-table-row>
                <x-table-data colspan="9">
                    {{ __('No Record Found') }}
                </x-table-data>
            </x-table-row>
            @endforelse
        </tbody>
    </x-table-element>
    <div class="py-3">{{ $users->links() }}</div>
    <x-status-change />
    <x-modal.notes-modal />
    <script>
        window.$modals = {
            show(name, id) {
                window.dispatchEvent(
                    new CustomEvent('modal', {
                        detail: name,
                        id: id
                    })
                );
            }
        }
        let changeStatus = (e) => {
            const id = e.currentTarget.getAttribute('id');
            modal = id.split('-');
            if (modal.length === 2) {
                $modals.show(modal[0], id);
                document.querySelector(`#${modal[0]} form`).setAttribute('action', e.currentTarget.dataset.url);
                if (e.currentTarget.dataset.status == 1) {
                    document.getElementById('activeBtn').style.display = "none";
                    document.getElementById('activePara').style.display = "none";
                    document.getElementById('activeIcon').style.display = "none";
                } else {
                    document.getElementById('deactiveBtn').style.display = "none";
                    document.getElementById('deactivePara').style.display = "none";
                    document.getElementById('deactiveIcon').style.display = "none";
                }
            }
        }
        // active and deactive the employee
        function formSubmit(e) {
            e.target.closest('form').submit();
        }
    </script>
</section>
@endsection