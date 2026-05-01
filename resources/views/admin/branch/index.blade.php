@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Branches') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Branches') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
            <a>{{ __('Branches') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2">
        <div class="flex justify-end w-full pt-2 mb-2">
            <x-add-button-link content="Add Branch" url="{{ route(auth()->user()->roleName . 'branch.create') }}" />
        </div>
        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>{{ __('Sr No.') }}</x-table-head>
                    <x-table-head>{{ __('Name') }}</x-table-head>
                    <x-table-head>{{ __('Branch ID') }}</x-table-head>
                    <x-table-head>{{ __('Location') }}</x-table-head>
                    <x-table-head>{{ __('Address') }}</x-table-head>
                    <x-table-head>{{ __('Contact') }}</x-table-head>
                    <x-table-head>{{ __('GST No.') }}</x-table-head>
                    <x-table-head>{{ __('Opened At') }}</x-table-head>
                    @can('isAdmin')
                        <x-table-head>{{ __('Action') }}</x-table-head>
                    @endcan
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($branches as $key => $branch)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $key + $branches->firstItem() }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->name }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->id }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->location }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->address }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->phone }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $branch->gst_no }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($branch->open_at) }}</span>
                        </x-table-data>
                        {{-- Action --}}
                        @can('isAdmin')
                            <x-table-data class="relative">
                                <x-modal.action-modal class="-left-20">
                                    <li>
                                        <a href="{{ route(auth()->user()->roleName . 'branch.edit', $branch) }}"
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
                                        <x-delete-confirmation-modal label :values="$branch" :message="'Are you sure you want to remove this branch ?'"
                                            routename="{{ route(auth()->user()->roleName . 'branch.delete', $branch) }}" />
                                    </li>
                                </x-modal.action-modal>
                            </x-table-data>
                        @endcan
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="10">{{ __('No Record Found') }}</x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
        <div>
            {{ $branches->links() }}
        </div>
    </section>
@endsection
