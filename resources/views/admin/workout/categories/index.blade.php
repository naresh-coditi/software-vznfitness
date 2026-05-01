@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __('Workout Categories') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Workout Categories') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Workout Categories') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2" x-data="{}">
        <div class="flex items-center justify-between">
            {{-- <form action="" method="get" class="py-2 w-full">
                <div class="flex items-end md:items-center gap-4 flex-col md:flex-row">
                    <div class="w-full md:w-1/2 -mt-2">
                        <x-text-input id="search" class="block w-full" type="search" name="search"
                            value="{{ $request->search }}" placeholder="Search By  i.e Name" />
                    </div>
                    <div class="flex items-center gap-8 w-full pt-3 md:pt-0">
                        <x-primary-button>{{ __('Search') }}</x-primary-button>
                    </div>
                </div>
            </form> --}}
            <div class="w-full text-right mb-2">
                <button type="button"
                    class="rounded bg-slate-900 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    x-on:click.prevent='$dispatch("open-modal", "workoutcategoryCreate")'>
                    {{ __('Add Category') }}
                </button>
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
                        {{ __('Description') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Created By') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Created On') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Actions') }}
                    </x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($categories as $key => $category)
                    <x-table-row>
                        <x-table-data>
                            <span>{{ $key + $categories->firstItem() }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span class="block antialiased font-sans truncate text-sm leading-normal text-blue-gray-900">
                                {{ $category->name }}
                            </span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $category->description }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ $category->createdBy->userProfile->fullName }}</span>
                        </x-table-data>
                        <x-table-data>
                            <span>{{ dateFormat($category->created_at) }}</span>
                        </x-table-data>
                        {{-- Action --}}
                        <x-table-data class="relative">
                            <x-modal.action-modal class="-left-32">
                                <li>
                                    <a href="{{ route(auth()->user()->roleName . 'workout.categories.edit', $category) }}"
                                        class="cursor-pointer hover:text-blue-500  flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 576 512">
                                            <title>Edit</title>
                                            <path
                                                d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                            </path>
                                        </svg>
                                        {{ __('Edit') }}
                                    </a>
                                </li>
                                <li>
                                    <x-delete-confirmation-modal label :values="$category" :message="'Are you sure you want to remove this category ?'"
                                        routename="{{ route(auth()->user()->roleName . 'workout.categories.delete', $category) }}" />
                                </li>
                            </x-modal.action-modal>
                        </x-table-data>
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="6">
                            {{ __('No Record Found') }}
                        </x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
        <div class="py-3">{{ $categories->links() }}</div>
        <x-modal.workout.category.create />
    </section>
@endsection
