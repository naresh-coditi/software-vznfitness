@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
<title>{{ __("Trainers") }}</title>
@endpush @push('breadcrum')
<div class="flex items-center gap-4 py-2 text-xl font-bold">
  <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">
    <svg
      class="w-6 h-6"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 24 24"
      fill="#FFA600"
    >
      <path d="M0 0h24v24H0V0z" fill="none"></path>
      <path
        d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"
      ></path>
    </svg>
  </a>
  <div>
    <span>{{ __("Members") }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
      <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{
        __("Dashboard")
      }}</a>
      &raquo;
      <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">{{
        __("Trainers")
      }}</a>
      &raquo;
      <a>{{ __("Add Trainer") }}</a>
    </span>
  </div>
</div>
@endpush @section('main-section')
<section class="max-w-6xl w-full mx-auto px-6 mt-2 py-6 bg-white">
  <div class="max-w-5xl m-auto">
    <form
      action="{{ route(auth()->user()->roleName . 'trainers.store') }}"
      method="post"
    >
      @csrf
      <div class="space-y-12">
        <div class="md:flex w-full gap-10">
          <div
            class="grid w-full grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2"
          >
            {{-- First Name --}}
            <div class="sm:col-span-3">
              <x-input-label
                for="first_name"
                :value="__('First Name')"
                astrik
              />
              <x-text-input
                id="first_name"
                type="text"
                name="first_name"
                required
                autofocus
              />
              <x-input-error
                :messages="$errors->get('first_name')"
                class="mt-2"
              />
            </div>
            {{-- Last Name --}}
            <div class="sm:col-span-3">
              <x-input-label for="last_name" :value="__('Last Name')" />
              <x-text-input
                id="last_name"
                type="text"
                name="last_name"
                autofocus
              />
              <x-input-error
                :messages="$errors->get('last_name')"
                class="mt-2"
              />
            </div>
            {{-- Email --}}
            <div class="sm:col-span-3">
              <x-input-label for="email" :value="__('Email')" astrik />
              <x-text-input id="email" type="text" name="email" autofocus />
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            {{-- Branch --}}
            <div class="sm:col-span-3">
              <x-input-label for="branch" :value="__('Branch')" astrik />
              <select
                name="branch"
                id="branch"
                class="w-full rounded-lg border-0 ring-1 ring-slate-200 bg-[#F5F5F5] focus:ring-orange-600 focus:outline-0"
              >
                @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">
                  {{ $branch->name . ' | ' }}{{ $branch->location }}
                </option>
                @endforeach
              </select>
              <x-input-error :messages="$errors->get('branch')" class="mt-2" />
            </div>
            {{-- Phone --}}
            <div class="sm:col-span-3">
              <x-input-label for="phone" :value="__('Phone')" astrik />
              <x-text-input
                id="phone"
                type="tel"
                name="phone"
                required
                autofocus
                autocomplete="phone"
              />
              <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            {{-- Gender --}}
            <div class="sm:col-span-3">
              <x-input-label for="gender" :value="__('Gender')" astrik />
              <div class="flex items-center gap-4 mt-1 md:flex-row">
                <label for="male" class="flex items-center gap-1">
                  <input
                    type="radio"
                    name="gender"
                    id="male"
                    value="male"
                    class="accent-orange-500"
                  />
                  <span>{{ __("Male") }}</span>
                </label>
                <label for="female" class="flex items-center gap-1">
                  <input
                    type="radio"
                    name="gender"
                    id="female"
                    value="female"
                    class="accent-orange-500"
                  />
                  <span>{{ __("Female") }}</span>
                </label>
              </div>
              <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            {{-- Experience --}}
            <div class="sm:col-span-6">
              <x-input-label
                for="experience"
                :value="__('Experience')"
                astrik
              />
              <textarea
                name="experience"
                id="experience"
                cols="3"
                rows="1"
                style="min-height: 100px"
                class="w-full rounded-lg border-0 ring-1 ring-slate-200 bg-[#F5F5F5] focus:ring-orange-600 focus:outline-0']"
                >{{ old("experience") }}</textarea
              >
              <x-input-error
                :messages="$errors->get('experience')"
                class="mt-2"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-x-6">
        <a
          href="{{ route(auth()->user()->roleName . 'trainers.index') }}"
          class="text-sm font-semibold leading-6 text-gray-900"
          >Cancel</a
        >
        <x-primary-button>Submit</x-primary-button>
      </div>
    </form>
  </div>
</section>
@push('script')
{{-- Add your scripts here if needed --}}
@endpush @endsection
