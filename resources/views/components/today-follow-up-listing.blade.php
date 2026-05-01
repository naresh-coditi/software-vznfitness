@props(['leads' => null])
<section class="px-6 py-4 overflow-hidden pt-10" x-data="notes">
    <header class="flex items-center justify-between pb-3">
        <h2 class="text-2xl">Today Follow Up Leads</h2>
    </header>
    <div>
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
                        {{ __('Gender') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Membership Interested') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Note') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Follow Up Date') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Status') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Created By') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Actions') }}
                    </x-table-head>
                </x-table-row>
            </thead>
            <tbody>
                @forelse ($leads as $key => $lead)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $key + $leads->firstItem() }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block font-sans text-sm leading-normal text-blue-gray-900">
                                {{ $lead->first_name . ' ' . $lead->last_name }}
                            </span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $lead->phone }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $lead->gender }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $lead->membership_interested }}</span>
                        </x-table-data>
                        <x-table-data>
                            <div class="flex justify-center">
                                <button
                                    x-on:click.prevent='$dispatch("open-modal", "leadNotes"),openModal("{{ route(auth()->user()->roleName . 'lead.notes.store', $lead) }}",{!! json_encode($lead->notes) !!})'>
                                    <svg class="w-4 h-4 mr-2 text-orange-400 }}" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-width="2"
                                            d="M3 1v22h13l5-5V1H3zm3 16h5m-5-4h12M6 9h10M3 5h18m0 12h-6v6">
                                        </path>
                                    </svg>
                                </button>
                                <span>({{ $lead->notes->count() }})</span>
                            </div>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($lead->follow_up_date) }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span
                                class="inline-flex items-center rounded-md {{ $lead->getStatus ? $lead->getStatus['color'] : '' }} px-2 py-1 text-xs font-medium">
                                {{ $lead->getStatus ? $lead->getStatus['name'] : '' }}
                            </span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $lead->createdByProfile->fullName }}</span>
                        </x-table-data>
                        {{-- Action --}}
                        <x-table-data class="relative">
                            <div class="flex gap-2 items-center">
                                @can('isAdmin')
                                    <a href="{{ route(auth()->user()->roleName . 'user.create', $lead) }}"
                                        class="flex items-center gap-2 hover:text-green-500">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <title>Convert lead to member</title>
                                            <path
                                                d="M14 14.252V22H4C4 17.5817 7.58172 14 12 14C12.6906 14 13.3608 14.0875 14 14.252ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM18 17V13.5L23 18L18 22.5V19H15V17H18Z">
                                            </path>
                                        </svg>
                                    </a>
                                @endcan
                                <a href="{{ route(auth()->user()->roleName . 'lead.view', $lead) }}"
                                    class="flex items-center gap-2 hover:text-yellow-500">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <title>View</title>
                                        <path
                                            d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ route(auth()->user()->roleName . 'lead.edit', $lead) }}"
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
                                </a>
                                {{-- Delete Confirmation Modal  --}}
                                <x-delete-confirmation-modal :values="$lead" :message="'Are you sure you want to remove this lead ?'"
                                    routename="{{ route(auth()->user()->roleName . 'lead.delete', $lead) }}" />
                            </div>
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
        <div>
            {{ $leads->links() }}
        </div>
    </div>
</section>
