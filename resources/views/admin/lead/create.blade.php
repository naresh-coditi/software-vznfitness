@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
<title>{{ __(' Leads') }}</title>
@endpush

@push('breadcrum')
<div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
    <a href="{{ route(auth()->user()->roleName . 'lead.index') }}">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
            <path d="M0 0h24v24H0V0z" fill="none"></path>
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
        </svg>
    </a>
    <div>
        <span>{{ __('Leads') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
            <a href="{{ route(auth()->user()->roleName . 'lead.index') }}">{{ __('Leads') }}</a> &raquo;
            <a>{{ __('Create Lead') }}</a>
        </span>
    </div>
</div>
@endpush

@section('main-section')
<section class="w-full px-6 mt-2 py-6">
    <div>
        <form action="{{ route(auth()->user()->roleName . 'lead.store') }}" id="updateUserForm" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_type" value="1">
            <div class="space-y-12">
                <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    </div>
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                        {{-- First Name --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="first_name" :value="__('First Name')" astrik />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                :value="old('first_name')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        {{-- last namae --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                :value="old('last_name')" autofocus />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                        {{-- gender --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="gender" :value="__('Gender')" astrik />
                            <div class="flex items-center gap-4 mt-1 md:flex-row">
                                <label for="male" class="flex items-center gap-1">
                                    <input type="radio" name="gender" id="male" checked value="male"
                                        class="accent-orange-500">
                                    <span>{{ __('Male') }}</span>
                                </label>
                                <label for="female" class="flex items-center gap-1">
                                    <input type="radio" name="gender" id="female" value="female"
                                        class="accent-orange-500">
                                    <span>{{ __('Female') }}</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        {{-- phone --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="phone" :value="__('phone')" astrik />
                            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                                :value="old('phone')" required autofocus autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        {{-- Follow up date --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="follow_up_date" :value="__('Follow Up Date')" astrik />
                            <x-text-input id="follow_up_date" class="block mt-1 w-full" type="date"
                                name="follow_up_date" :value="old('follow_up_date')" required autofocus
                                autocomplete="follow_up_date" />
                            <x-input-error :messages="$errors->get('follow_up_date')" class="mt-2" />
                        </div>
                        {{-- membership_interested --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="membership_interested" :value="__('Membership Interested')" />

                            <select name="membership_interested" id="membership_interested"
                                class="membership_interested block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->name }}">
                                    {{ $plan->name }}
                                </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('membership_interested')" class="mt-2" />
                        </div>

                        {{-- Offer amount --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="amount_offer" :value="__('Amount offer')" />
                            <x-text-input id="amount_offer" class="block mt-1 w-full" type="number" name="amount_offer"
                                :value="old('amount_offer')" autofocus autocomplete="amount_offer" />
                            <x-input-error :messages="$errors->get('amount_offer')" class="mt-2" />
                        </div>

                        {{-- Lead Source --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="source" :value="__('Source')" />
                            <select name="source" id="source"
                                class="source block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="" disabled selected>Select</option>
                                @foreach ($sources as $source)
                                <option value="{{ $source['id'] }}">
                                    {{ $source['name'] }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>
                        {{-- Upload Image --}}
                        <div class="sm:col-span-3">
                            <x-input-label for="profile_image" :value="__('Select Profile Image')" />

                            <div class="flex flex-col items-start mt-2">
                                <input
                                    type="file"
                                    name="profile_image"
                                    class="block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300
                                        file:rounded-l-md file:text-sm file:font-semibold
                                        file:bg-orange-500 file:text-white hover:file:bg-orange-500 hover:scale-105"
                                    accept="image/*" />
                                <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                            </div>
                        </div>


                        {{-- Note --}}
                        <div class="sm:col-span-6">
                            <x-input-label for="note" :value="__('Note')" />
                            <textarea name="note" id="note" cols="3" rows="1"
                                class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm resize-y">{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route(auth()->user()->roleName . 'lead.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button type="submit"
                    class="rounded bg-brand px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand">Create</button>
            </div>
        </form>
    </div>
</section>
@endsection