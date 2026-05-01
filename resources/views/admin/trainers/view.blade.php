@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
<title>{{ __('Trainers') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
<div class="breadcrumb flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm text-xl font-bold">
    <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
            <path d="M0 0h24v24H0V0z" fill="none"></path>
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
        </svg>
    </a>
    <div>
        <span>{{ __('Trainers') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a href="{{ route(auth()->user()->roleName . 'trainers.index') }}">{{ __('Trainers') }}</a>
            &raquo;
            <a>{{ __('View Trainer') }}</a>
        </span>
    </div>
</div>
@endpush

{{-- Main Section --}}
@section('main-section')
<section class="main-section w-full px-8 py-6 mt-4">
    <header class="section-header pb-3 border-b border-gray-500">
        <h2 class="section-title text-gray-900 text-2xl font-semibold">{{ __('Personal Information') }}</h2>
    </header>

    <div class="info-wrapper grid grid-cols-1 lg:grid-cols-2 gap-10 mt-6">
        <div class="info-card bg-white shadow-md rounded-lg p-6">
            <h3 class="info-title text-lg font-bold text-gray-700 mb-4 text-center">{{ __('Basic Details') }}</h3>
            <hr>
            <div class="info-content">
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('First Name') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->userProfile->first_name }}</span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Last Name') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->userProfile->last_name }}</span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Gender') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->userProfile->gender }}</span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Email') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->email }}</span>
                </div>
            </div>
        </div>

        <div class="info-card bg-white shadow-md rounded-lg p-6">
            <h3 class="info-title text-lg font-bold text-gray-700 mb-4 text-center">{{ __('Additional Details') }}</h3>
            <hr>
            <div class="info-content">
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Phone Number') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->phone }}</span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Experience') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ $trainer->userProfile->experience }}</span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label text-gray-500">{{ __('Start Date') }}:</span>
                    <span class="info-value text-gray-800 font-medium">{{ dateFormat($trainer->created_at) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Custom CSS --}}
@push('css')
<style>
    .breadcrumb {
        background-color: #f9fafb;
    }

    .main-section {
        background-color: #f8f8f8;
    }

    .section-header {
        border-bottom-width: 2px;
    }

    .section-title {
        font-size: 1.75rem;
        color: #2d3748;
    }

    .info-wrapper {
        display: grid;
        gap: 1.5rem;
    }

    .info-card {
        background-color: #ffffff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .info-title {
        font-size: 1.25rem;
        color: #4a5568;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .info-label {
        font-size: 0.875rem;
        color: #a0aec0;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
    }
</style>
@endpush
