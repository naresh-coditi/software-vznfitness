@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Leads') }}</title>
@endpush

{{-- Breadcrum --}}
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
                <a>{{ __('Notes') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        {{-- New Comment --}}
        <div class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6">
            <form action="{{ route(auth()->user()->roleName . 'lead.notes.store', $user) }}" method="post" class="gap-2">
                @csrf
                <div class="w-full">
                    <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                        {{ __('Enter Note') }}
                    </label>
                    <textarea id="note" rows="3" name="note"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border
                        border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <x-input-error :messages="$errors->get('note')" class="mt-2" />
                </div>
                <div class="w-full mt-4">
                    <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                        {{ __('Next Follow Up Date') }}
                    </label>
                    <x-text-input name="next_follow_up_date" type="date" />
                    <x-input-error :messages="$errors->get('next_follow_up_date')" class="mt-2" />
                </div>
                <div class="gap-2 flex mt-6">
                    <a href="{{ route(auth()->user()->roleName . 'lead.index') }}"
                        class="px-7 mb-4 py-3 bg-white text-black font-medium text-sm leading-snug border
                        rounded ripple-surface-light">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" x-bind:disabled="disable"
                        class="px-7 mb-4 py-3 bg-slate-900 hover:bg-slate-600 text-white font-medium text-sm leading-snug
                        rounded shadow-md  hover:shadow-lg ripple-surface-light">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>
        {{-- old notes --}}
        @forelse ($notes as $note)
            <article class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6 mt-9">
                <h2 class="hidden"></h2>
                <div class="shadow-sm p-3 text-sm leading-6 rounded border mb-4">
                    <div class="flex items-center gap-8 justify-between">
                        <div>
                            <p>
                                <span class="font-bold">
                                    {{ __('Note : ') }}
                                </span>
                                {{ $note->note }}
                            </p>
                            <p>
                                <span class="font-bold">
                                    {{ __('Next Follow Up Date : ') }}
                                </span>
                                {{ dateFormat($note->next_follow_up_date) }}
                            </p>
                        </div>
                        {{-- Delete Confirmation Modal  --}}
                        <x-delete-confirmation-modal :values="$user" :message="'Are you sure you want to remove this note ?'"
                            routename="{{ route(auth()->user()->roleName . 'lead.notes.delete', $note) }}" />
                    </div>
                    <div class="flex justify-between gap-4 mt-3">
                        <div class="flex">
                            <div class="text-gray-400"> {{ __('Created by:') }}</div>
                            <div class="ml-2">
                                {{ $note->createdBy->userProfile->fullName ?? '' }}
                            </div>
                        </div>
                        <div class="flex">
                            <div class="text-gray-400">{{ __('Date:') }}</div>
                            <div class="ml-2"> {{ dateFormat($note->created_at) }}</div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <article class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6 mt-9">
                <h2>{{ __('No Record Found') }}</h2>
            </article>
        @endforelse
    </section>
@endsection
