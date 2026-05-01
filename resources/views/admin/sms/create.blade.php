@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
<title>{{ __('SMS Templates') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
<div class="pl-6 py-2 md:mt-10 mt-5 text-xl font-bold">
    <span>{{ __('SMS Templates') }}</span>
    <span class="block text-xs font-normal text-gray-500 mt-2">
        <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
        &raquo;
        <a href="{{ route(auth()->user()->roleName . 'sms.index') }}">{{ __('Templates') }}</a>
    </span>
</div>
@endpush

@section('main-section')
<section class="max-w-4xl mx-auto px-6 py-8 bg-white shadow-lg rounded-lg">
    <div class="text-center mb-6 flex items-center justify-center">
        <h2 class="text-2xl font-semibold text-gray-700 mr-2">Create New</h2>
        <svg class="h-8 w-8 text-orange-500 hover:scale-110" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
        </svg>
        <span class="text-2xl font-semibold text-gray-700 ml-2">Template</span>
    </div>

    {{-- Form --}}
    <form action="{{ route(auth()->user()->roleName . 'sms.create') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            {{-- Title Field --}}
            <div class="flex flex-col">
                <label for="title" class="mb-2 font-medium text-gray-700">{{ __('Title') }}</label>
                <input type="text" name="title" id="title" placeholder="{{ __('Enter title') }}"
                    class="border border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 p-3 transition duration-200" required>
                @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Subject Field --}}
            <div class="flex flex-col">
                <label for="subject" class="mb-2 font-medium text-gray-700">{{ __('Subject') }}</label>
                <input type="text" name="subject" id="subject" placeholder="{{ __('Enter subject') }}"
                    class="border border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 p-3 transition duration-200" required>
                @error('subject')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Description Field --}}
            <div class="flex flex-col">
                <label for="description" class="mb-2 font-medium text-gray-700">{{ __('Description') }}</label>
                <textarea name="description" id="description" rows="4" placeholder="{{ __('Enter description') }}"
                    class="border border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 p-3 transition duration-200" required></textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-center mt-6">
            <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-md shadow-md hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-300 transition duration-200">
                {{ __('Add Template') }}
            </button>
            <a href="{{ route(auth()->user()->roleName . 'sms.index') }}" class="bg-red-500 text-white px-6 py-3 ml-2 rounded-md shadow-md hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-200">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</section>
@endsection
