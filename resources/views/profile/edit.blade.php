@extends('admin.layouts.main')
@section('main-section')
    @push('breadcrum')
        <div class="border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
            {{ __('Profile') }}
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a>{{ __('Profile') }}</a>
            </span>
        </div>
    @endpush

    <div>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6 py-6">
            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div> --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div>
                    @include('profile.partials.update-profile-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function setProfileImage(event) {
            const image = document.getElementById('profileImage');
            const reader = new FileReader();
            reader.onload = function() {
                image.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            return;
        }
    </script>
@endpush
{{-- </x-app-layout> --}}
