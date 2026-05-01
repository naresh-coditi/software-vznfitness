@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
    <title>{{ __('Transactions') }}</title>
@endpush

{{-- Breadcrumb --}}
@push('breadcrum')
    <div class="flex items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm text-xl font-bold">
        <a href="{{ route(auth()->user()->roleName . 'user.index') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
            </svg>
        </a>
        <div>
            <span>{{ __('Members') }}</span>
            <span class="block text-xs font-normal text-gray-500 mt-2">
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a> &raquo;
                <a
                    href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}">{{ __('Transaction') }}</a>&raquo;
                <a>{{ __('Edit') }}</a>
            </span>
        </div>
    </div>
@endpush

{{-- Main Section --}}
@section('main-section')
    <section class="w-full px-6 py-6 mt-2">
        <div>
            <form action="{{ route(auth()->user()->roleName . 'transaction.update', $transaction) }}" id="updateUserForm"
                method="post">
                @csrf
                {{-- Form Fields --}}
                <div class="space-y-12">
                    {{-- Section Title --}}
                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 border-b border-gray-900/10 pb-12 md:grid-cols-3">
                        <div>
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Transaction Information</h2>
                        </div>

                        {{-- Form Inputs --}}
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
                            {{-- Transaction Date --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="transaction_date" :value="__('Transaction Date')" astrik />
                                <x-text-input id="transaction_date" class="block mt-1 w-full" type="date"
                                    name="transaction_date" :value="dateformat($transaction->transaction_date, 'Y-m-d')" required autofocus />
                                <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                            </div>

                            {{-- Amount --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                    :value="$transaction->amount" autofocus />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            {{-- Remaining Balance --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="remaining_balance" :value="__('Remaining Balance')" />
                                <x-text-input id="remaining_balance" class="block mt-1 w-full" type="number"
                                    name="remaining_balance" :value="$transaction->remaining_amount" autofocus />
                                <x-input-error :messages="$errors->get('remaining_balance')" class="mt-2" />
                            </div>

                            {{-- Payment Method --}}
                            <div class="sm:col-span-3">
                                <x-input-label for="method_type" :value="__('Method Type')" />
                                <select name="method_type" id="method_type" required
                                    class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                    <option value="" disabled>{{ __('Select a method') }}</option>

                                    @foreach ($methods as $method)
                                        <option value="{{ $method['name'] }}"
                                            {{ $method['name'] == old('method_type', $transaction->method_type) ? 'selected' : '' }}>
                                            {{ $method['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('method_type')" class="mt-2" />
                            </div>

                            {{-- Note --}}
                            <div class="sm:col-span-3 ">
                                <x-input-label for="note" :value="__('Note')" />
                                <x-text-input id="note" class="block mt-1 w-full" type="text" name="note"
                                    :value="$transaction->note" autofocus autocomplete="note" />
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="mt-6 flex items-center justify-end gap-x-6 text-black font-medium">
                    <a href="{{ route(auth()->user()->roleName . 'user.index') }}">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="rounded-md bg-orange-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
