@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Membership Plans') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 md:mt-10 mt-5 text-xl font-bold">
        <span>{{ __('Membership Plans') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Plans') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2">
        {{-- Buttons --}}
        <div class="flex items-center gap-4 justify-end pt-2 mb-2">
            <div>
                <x-add-button-link content="ADD PLAN" url="{{ route(auth()->user()->roleName . 'membershipplan.create') }}" />
            </div>
        </div>
        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>{{ __('Sr No.') }}</x-table-head>
                    <x-table-head>{{ __('Plan Name') }}</x-table-head>
                    <x-table-head>{{ __('Status') }}</x-table-head>
                    <x-table-head>{{ __('Validity') }}</x-table-head>
                    <x-table-head>{{ __('Cost') }}</x-table-head>
                    <x-table-head>{{ __('Created By') }}</x-table-head>
                    <x-table-head>{{ __('Updated By') }}</x-table-head>
                    <x-table-head>{{ __('Actions') }}</x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($plans as $key => $plan)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $key + $plans->firstItem() }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->name }}</span>
                        </x-table-data>
                        <x-table-data>
                            <label class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox" name="status" id="statusModal-{{ $key }}"
                                    data-url = "{{ route(auth()->user()->roleName . 'membershipplan.status.update', $plan) }}"
                                    class="sr-only peer" data-on="Active" data-off="InActive"
                                    {{ $plan->status ? 'checked' : '' }} data-status={{ $plan->status }}
                                    onchange="changeStatus(event)">
                                <div
                                    class="w-11 h-6 bg-red-600 peer-focus:outline-none
                                    rounded-full peer peer-checked:after:translate-x-full
                                    peer-checked:after:border-white after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border
                                    after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-green-600">
                                </div>
                                <p class="ml-3">
                                    {{ $plan->status ? 'Active' : 'Deactive' }}
                                </p>
                            </label>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->validity . ' days' }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->cost }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->createdByProfile->fullName }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $plan->updatedByProfile->fullName }}</span>
                        </x-table-data>
                        {{-- Action --}}
                        <x-table-data class="relative">
                            <x-modal.action-modal class="-left-32">
                                <li>
                                    <a href="{{ route(auth()->user()->roleName . 'membershipplan.edit', $plan) }}"
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
                                    <x-delete-confirmation-modal label :values="$plan" :message="'Are you sure you want to remove this plan ?'"
                                        routename="{{ route(auth()->user()->roleName . 'membershipplan.delete', $plan) }}" />
                                </li>
                            </x-modal.action-modal>
                        </x-table-data>
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="10">
                            {{ __('No Record Found') }}</x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
        <div class="py-3">{{ $plans->links() }}</div>
        <x-membership-plan-status-change />
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
@endpush
