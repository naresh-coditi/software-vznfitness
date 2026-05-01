@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Membership Plans') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'membershipplan.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Membership Plans') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a href="{{ route(auth()->user()->roleName . 'membershipplan.index') }}">{{ __('Plans') }}</a>
                &raquo;
                <a>{{ __('Create') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 flex items-center justify-center sm:pt-20">
        <form action="{{ route(auth()->user()->roleName . 'membershipplan.store') }}" method="post"
            class="block w-full md:w-1/2 px-6 py-4 space-y-3">
            @csrf
            {{-- Membership Name --}}
            <div class="w-full">
                <x-input-label for="name" :value="__('Name')" astrik />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            {{-- Vlaidity --}}
            <div class="w-full">
                <x-input-label for="validity" :value="__('Validity (Number Of Days)')" astrik />
                <x-text-input id="validity" class="block mt-1 w-full" type="number" name="validity" :value="old('validity')"
                    required autofocus />
                <x-input-error :messages="$errors->get('validity')" class="mt-2" />
            </div>
            {{-- Cost --}}
            <div class="w-full">
                <x-input-label for="cost" :value="__('Cost')" astrik />
                <x-text-input id="cost" class="block mt-1 w-full" type="number" name="cost" :value="old('cost')"
                    required autofocus />
                <x-input-error :messages="$errors->get('cost')" class="mt-2" />
            </div>
            <div class="flex items-center gap-4 justify-end pt-4">
                <a href="{{ route(auth()->user()->roleName . 'membershipplan.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-primary-button class="ms-3">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection
