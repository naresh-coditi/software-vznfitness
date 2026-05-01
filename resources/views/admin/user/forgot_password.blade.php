@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Members') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'user.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Members') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
                &raquo;
                <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a>
                &raquo;
                <a>{{ __('Forgot Password') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="flex flex-col pt-12 gap-8 justify-center items-center">
        <form action="{{ route(auth()->user()->roleName . 'user.forgot.password.link', $user) }}" method="post">
            @method('PATCH')
            @csrf
            <x-primary-button>Send Password</x-primary-button>
        </form>
        <span>{{ __('OR') }}</span>
        <form action="{{ route(auth()->user()->roleName . 'user.forgot.password', $user) }}" method="post"
            class="w-1/2 block">
            @method('PATCH')
            @csrf
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="confirm_password" :value="__('Confirm Password')" />

                <x-text-input id="confirm_password" class="block mt-1 w-full" type="password" name="confirm_password"
                    required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </section>
@endsection
