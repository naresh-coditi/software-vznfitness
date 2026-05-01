@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
    <title>{{ __('Edit Trainer') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Members') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">{{ __('Trainers') }}</a> &raquo;
                <a>{{ __('Edit Trainer') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-8 py-6 mt-4 bg-gray-50 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Edit Trainer Information') }}</h2>

        <form action="{{ route(auth()->user()->roleName . 'trainers.update', $trainer) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                {{-- First Name --}}
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" type="text" name="first_name" :value="$trainer->userProfile->first_name" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                {{-- Last Name --}}
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" type="text" name="last_name" :value="$trainer->userProfile->last_name" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="$trainer->email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Branch --}}
                <div>
                    <x-input-label for="branch" :value="__('Branch')" required />
                    <select name="branch" id="branch"
                        class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm">
                        <option value="" disabled>Select a branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ $trainer->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name . ' | ' . $branch->location }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('branch')" class="mt-2" />
                </div>

                {{-- Phone --}}
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" type="tel" name="phone" :value="$trainer->phone" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                {{-- Gender --}}
                <div>
                    <x-input-label for="gender" :value="__('Gender')" required />
                    <div class="flex items-center gap-4 mt-1">
                        <label for="male" class="flex items-center gap-1">
                            <input type="radio" name="gender" id="male" value="male" class="accent-orange-500"
                                {{ $trainer->userProfile->gender == 'Male' ? 'checked' : '' }}>
                            <span>{{ __('Male') }}</span>
                        </label>
                        <label for="female" class="flex items-center gap-1">
                            <input type="radio" name="gender" id="female" value="female" class="accent-orange-500"
                                {{ $trainer->userProfile->gender == 'Female' ? 'checked' : '' }}>
                            <span>{{ __('Female') }}</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                {{-- Experience --}}
                <div>
                    <x-input-label for="experience" :value="__('Experience')" />
                    <x-text-input id="experience" type="text" name="experience" :value="$trainer->userProfile->experience" required />
                    <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}"
                    class="text-sm font-semibold text-gray-900">Cancel</a>
                <x-primary-button>{{ __('Update Trainer') }}</x-primary-button>
            </div>
        </form>
    </section>

    @push('script')
        {{-- Add your scripts here if needed --}}
    @endpush
@endsection
