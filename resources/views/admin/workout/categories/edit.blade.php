@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Workout Categories') }}</title>
@endpush

@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm  text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Edit Category') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a
                    href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}">{{ __('Workout Categories') }}</a>
                &raquo;
                <a>{{ __('Edit Category') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        <form action="{{ route(auth()->user()->roleName . 'workout.categories.update', $category) }}" method="post" class="md:w-1/2 m-auto w-full">
            @csrf
            @method('PUT')
            <div>
                {{-- Name --}}
                <div class="sm:col-span-3">
                    <x-input-label for="name" :value="__('Plan Name')" astrik />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$category->name"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="description" :value="__('Plan Description')" astrik />
                    <textarea id="message" rows="4" name="description"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                        placeholder="Write description...">{{ $category->description }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route(auth()->user()->roleName . 'workout.categories.index') }}"
                    class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    </section>
@endsection
