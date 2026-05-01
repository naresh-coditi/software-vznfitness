@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
  <title>{{ __(' Roles') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'role.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Roles') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'role.index') }}">{{ __('Roles') }}</a> &raquo;
                <a>{{ __('Create') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 flex items-center justify-center pt-20">
        <form action="{{ route(auth()->user()->roleName . 'role.update', $role) }}" method="post"
            class="block w-1/2 border-2 rounded-lg px-6 py-4">
            @method('PUT')
            @csrf
            {{-- First Name --}}
            <div class="w-full">
                <x-input-label for="name" :value="__('Role Name')" astrik />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$role->name"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="sm:flex justify-end pt-4">
                <x-primary-button class="ms-3">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection
