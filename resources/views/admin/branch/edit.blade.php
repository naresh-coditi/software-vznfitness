@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Branches') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'branch.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Branches') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'branch.index') }}">{{ __('Branch') }}</a> &raquo;
                <a>{{ __('Edit') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 flex items-center justify-center">
        <form action="{{ route(auth()->user()->roleName . 'branch.update', $branch) }}" method="post"
            class="block md:w-1/2 w-full px-6 py-4 space-y-2">
            @method('PUT')
            @csrf
            <div class="md:flex items-center gap-6">
                {{-- Name --}}
                <div class="w-full">
                    <x-input-label for="name" :value="__('Branch Name')" astrik />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$branch->name"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Location --}}
                <div class="w-full">
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="$branch->location"
                        required autofocus />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
            <div class="lg:flex items-center gap-6">
                {{-- Phone --}}
                <div class="w-full">
                    <x-input-label for="phone" :value="__('Contact Number')" astrik />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                        :value="$branch->phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                {{-- GST No. --}}
                <div class="w-full">
                    <x-input-label for="gst" :value="__('GST Number')" />
                    <x-text-input id="gst" class="block mt-1 w-full" type="text" name="gst"
                        :value="$branch->gst" />
                    <x-input-error :messages="$errors->get('gst')" class="mt-2" />
                </div>
                {{-- Opening date --}}
                <div class="w-full">
                    <x-input-label for="open_at" :value="__('Opening Date')" astrik />
                    <x-text-input id="open_at" class="block mt-1 w-full" type="date" name="open_at"
                        :value="dateFormat($branch->open_at, 'Y-m-d')" />
                    <x-input-error :messages="$errors->get('open_at')" class="mt-2" />
                </div>
            </div>

            {{-- Address --}}
            <div>
                <x-input-label for="address" :value="__('Address')" astrik />
                <textarea required name="address" id="address" cols="10" rows="5"
                    class="block mt-1 w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm resize-y">{{ $branch->address }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4 justify-end pt-4">
                <a href="{{ route(auth()->user()->roleName . 'branch.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-primary-button class="ms-3">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection
