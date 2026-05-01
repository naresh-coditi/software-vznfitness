@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Settings') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
            <a>{{ __('Settings') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="px-16 m-auto pt-12">
        <div class="border-b-2 border-black">
            <ul class="flex items-center gap-2">
                <li>
                    <a href=""
                        class="{{ request()->is('*settings*') ? 'text-white bg-orange-600 shadow-sm' : 'hover:text-white hover:bg-gray-800 hover:shadow-sm' }} p-2 rounded-t-md block">
                        Membership schedule
                    </a>
                </li>
                <li>
                    <a href=""
                        class="{{ request()->is('*diet*') ? 'text-white bg-orange-600 shadow-sm' : 'hover:text-white hover:bg-gray-800 hover:shadow-sm' }} p-2 rounded-t-md block">
                        Diet Plans
                    </a>
                </li>
            </ul>
        </div>
        <section>

        </section>
    </section>
@endsection
