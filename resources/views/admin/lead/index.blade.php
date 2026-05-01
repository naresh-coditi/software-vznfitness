@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Leads') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
<div class="text-xl font-bold mb-4">
    <span>{{ __('Leads') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a>{{ __('Leads') }}</a>
    </span>
</div>
@endpush
@section('main-section')
<section class="w-full" x-data="notes">
    <div class="flex md:flex-row flex-col md:items-center gap-4 justify-between mb-4 ">
        <!-- x-filters.manage-pt-filter  -->
        <form action="" method="get" class="w-full order-2 sm:order-1 flex-1">
            <div class="flex flex-row items-center gap-x-2 sm:gap-x-4 sm:justify-start justify-between mb-4 sm:mb-0">
                <!-- Search Input -->
                <div class="sm:w-full sm:max-w-xs flex-1 sm:flex-none">
                    <input id="search" type="search"
                        class="border-0 ring-1 ring-slate-400 focus:ring-1 focus:ring-orange-600 focus:outline-none rounded-md text-sm w-full"
                        name="search" value="{{ $request->search }}" placeholder="Search by Name, Phone, ID">
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
            <x-add-button-link content="ADD LEED" url="{{ route(auth()->user()->roleName . 'lead.create') }}" />
        </div>
    </div>
    <x-table-element>
        <thead class="bg-gray-50">
            <x-table-row>
                <x-table-head>
                    {{ __('Sr No.') }}
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
                    {{ __('Amount Offered') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Source') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Note') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Follow Up Date') }}
                </x-table-head>
                <x-table-head>
                    {{ __('Created By') }}
                </x-table-head>
                @can('isAdmin')
                <x-table-head>
                    {{ __('Assigned To') }}
                </x-table-head>
                @endcan
                <x-table-head>
                    {{ __('Actions') }}
                </x-table-head>
            </x-table-row>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($users as $key => $user)
            <x-table-row>
                <x-table-data>
                    <span>{{ $key + $users->firstItem() }}</span>
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
                            {{ $user->status ? '' : 'checked' }} data-status={{ $user->status }}
                            onchange="changeStatus(event)">
                        <div
                            class="w-11 h-6 bg-blue-600 peer-focus:outline-none
                                    peer-focus:ring-4 peer-focus:ring-blue-300
                                    rounded-full peer peer-checked:after:translate-x-full
                                    peer-checked:after:border-white after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-red-600">
                        </div>
                        <p class="ml-3">
                            {{ $user->status ? 'Active' : 'Dead' }}
                        </p>
                    </label>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->membership_interested }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->amount_offer ? '₹' . $user->amountOffered : null }}</span>
                </x-table-data>
                <x-table-data>
                    <span>{{ $user->getSource }}</span>
                </x-table-data>
                <x-table-data>
                    {{-- Note Model --}}
                    <div class="flex justify-center items-center">
                        <button
                            x-on:click.prevent='$dispatch("open-modal", "leadNotes"),openModal("{{ route(auth()->user()->roleName . 'lead.notes.store', $user) }}",{!! json_encode($user->notes) !!})'>
                            <svg class="w-4 h-4 mr-2 {{ $user->notes->count() > 0 ? 'text-orange-400' : 'text-gray-400 cursor-not-allowed' }}"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="2"
                                    d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                </path>
                            </svg>
                        </button>
                        <span>({{ $user->notes->count() }})</span>
                    </div>
                </x-table-data>
                <x-table-data>
                    <span>{{ dateFormat($user->follow_up_date) }}</span>
                </x-table-data>
                <x-table-data class="flex flex-col text-center">
                    <!-- created by / duration / date and time -->
                    <span class="inline-block mt-1 rounded-md bg-sky-100 px-2 py-1 text-xs font-medium text-sky-800 ring-1 ring-inset ring-sky-600/70 hover:scale-105 text-center">{{ $user->createdByProfile->fullName }}</span>
                    <span>{{ $user->created_at->diffForHumans()}}</span>
                    <span>{{dateFormat($user->created_at)}}</span>
                    <span>{{ $user->created_at->setTimezone('Asia/Kolkata')->format('h:i:s A') }}</span>
                </x-table-data>
                @can('isAdmin')
                <x-table-data>
                    <span>{{ $user->assignedTo->assignedProfile->first_name . ' ' }}{{ $user->assignedTo->assignedProfile->last_name }}</span>
                </x-table-data>
                @endcan
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
                        @can('isAdmin')
                        <li>
                            <a href="javascript:void(0);" class="flex items-center gap-1 hover:text-blue-500"
                                @click="toggleStaffInfo('{{ 'staff-info_' . $user->id }}')">
                                <svg class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <span>Transfer to Staff</span>
                            </a>
                        </li>
                        <!-- Staff Info Div -->
                        <div id="{{ 'staff-info_' . $user->id }}" class="staff hidden absolute -left-48 top-12 bg-white border border-gray-300 shadow-lg p-4 z-50 max-h-48 overflow-y-auto rounded-lg transition-transform transform scale-95 hover:scale-100">
                            <h3 class="text-center text-lg font-semibold mb-4 text-gray-800">Select Staff</h3>
                            <ul class="space-y-2">
                                @foreach ($staff as $member)
                                <li class="flex items-center p-2 hover:bg-gray-100 rounded transition duration-200">
                                    <svg class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="17 1 21 5 17 9" />
                                        <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                                        <polyline points="7 23 3 19 7 15" />
                                        <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                                    </svg>
                                    <a href="{{ route(auth()->user()->roleName . 'lead.transfer.transfer', [$member->id, $user->id]) }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                                        {{ $member->userProfile->first_name }} {{ $member->userProfile->last_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        @endcan
                        <!-- send sms -->
                        <!-- <li>
                            <a href="javascript:void(0);" class="flex items-center gap-2 hover:text-blue-500" @click="toggleSmsInfo('{{'sms-info_'.$user->id}}')">
                                <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                </svg>
                                <span>Send SMS</span>
                            </a>
                        </li> -->
                        <!-- SMS Info Div -->
                        <div id="{{'sms-info_'.$user->id}}" class="hidden absolute -left-40 top-16 bg-white border border-gray-300 shadow-lg p-4 z-50 max-h-48 overflow-y-auto rounded-lg transition-transform transform scale-95 hover:scale-100">
                            <h3 class="text-center text-lg font-semibold mb-4 text-gray-800">Select Templates</h3>
                            <ul class="space-y-2">
                                @foreach ($templates as $template)
                                <li class="flex items-center p-2 hover:bg-gray-100 rounded transition duration-200">
                                    <svg class="h-5 w-5 text-orange-500 mr-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                    </svg>
                                    <a href="{{ route(auth()->user()->roleName .'sms.send', ['template' => $template, 'user' => $user]) }}" class="text-blue-600 hover:text-blue-800 transition duration-200">
                                        {{ __($template->title) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>


                        <!--  -->
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
    {{-- <x-lead-notes /> --}}
    <x-status-change />
    <x-modal.notes-modal />

</section>
@endsection

@push('script')
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

<script>
    function toggleStaffInfo(id) {
        const staffInfo = document.getElementById(id);
        staffInfo.classList.toggle('hidden'); // Toggle visibility of the staff info div
    }

    function toggleSmsInfo(divId, id) {
        const smsInfoDiv = document.getElementById(divId);
        smsInfoDiv.classList.toggle('hidden');
    }
    //global event listener
    window.addEventListener('click',function(event){
        const staffInfo = document.getElementsByClassName('staff');
        staffInfo.classList.toggle('hidden');
    });
</script>
@endpush
