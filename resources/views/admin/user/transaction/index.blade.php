@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Members') }}</title>
@endpush

{{-- Breadcrum --}}
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
                <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a> &raquo;
                <a>{{ __('Transaction') }}</a>
            </span>
        </div>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6">
        {{-- New Comment --}}
        <div class="bg-white xl:w-2/3 m-auto w-full rounded-lg p-6">
            <form action="{{ route(auth()->user()->roleName . 'transaction.store', $user) }}" method="post" class="gap-2">
                @csrf
                {{-- Method Type --}}
                <div class="sm:col-span-3">
                    <x-input-label for="method_type" :value="__('Method Type')" />
                    <select name="method_type" id="method_type" required
                        class="block mt-1 w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                        <option value="" disabled selected>{{ __('Select') }}</option>
                        @foreach ($methods as $method)
                            <option value="{{ $method['name'] }}"
                                {{ $method['name'] == old('method_type') ? 'selected' : '' }}>
                                {{ $method['name'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('method_type')" class="mt-2" />
                </div>
                {{-- Transaction Date --}}
                <div class="sm:col-span-3">
                    <x-input-label for="transaction_date" :value="__('Transaction Date')" />
                    <x-text-input id="transaction_date" class="block mt-1 w-full" type="date"
                        placeholder="Enter transaction_date" name="transaction_date" :value="old('transaction_date')" required
                        autocomplete="transaction_date" />
                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                </div>
                {{-- amount --}}
                <div class="sm:col-span-3">
                    <x-input-label for="amount" :value="__('Transaction Amount ( Automatically add to the total paid amount)')" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" placeholder="Enter amount"
                        name="amount" :value="old('amount')" required autocomplete="amount" />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>
                {{-- remaining amount --}}
                <div class="sm:col-span-3">
                    <x-input-label for="remaining_amount" :value="__('Remaining Amount ( Need to manually add remaining balance )')" />
                    <x-text-input id="remaining_amount" class="block mt-1 w-full" type="text"
                        placeholder="Enter remianing amount" name="remaining_amount" :value="$user->membershipDetails->remaining_amount"
                        autocomplete="remaining_amount" />
                    <x-input-error :messages="$errors->get('remaining_amount')" class="mt-2" />
                </div>
                {{-- Note --}}
                <div class="w-full">
                    <label class="block mb-2 text-sm text-gray-900 font-semibold" for="note">
                        {{ __('Enter Note') }}
                    </label>
                    <textarea id="note" rows="3" name="note"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border
                        border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="gap-2 flex mt-6">
                    <a href="{{ route(auth()->user()->roleName . 'user.index') }}"
                        class="px-7 mb-4 py-3 bg-white text-black font-medium text-sm leading-snug border
                        rounded ripple-surface-light">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" x-bind:disabled="disable"
                        class="px-7 mb-4 py-3 bg-orange-600 hover:bg-orange-500 text-white font-medium text-sm leading-snug
                        rounded shadow-md  hover:shadow-lg ripple-surface-light">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- old notes --}}
        <div class="max-w-6xl m-auto border-x mt-10 bg-white rounded-md">
            <x-table-element>
                <thead>
                    <x-table-row>
                        <x-table-head>
                            {{ __('Sr No.') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Transaction Date') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Amount') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Remaining Balance') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Payment Method') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Note') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created By') }}
                        </x-table-head>
                        @can('isAdmin')
                            <x-table-head>
                                {{ __('Action') }}
                            </x-table-head>
                        @endcan
                    </x-table-row>
                </thead>
                <tbody>
                    @forelse ($transactions as $key => $transaction)
                        <x-table-row>
                            <x-table-data>
                                <span>{{ $key + $transactions->firstItem() }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->transaction_date }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->amount }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->remaining_amount ?? 'N/A' }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->method_type }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->note }}</span>
                            </x-table-data>
                            <x-table-data>
                                <span>{{ $transaction->createdBy->userProfile->fullName ?? '' }}</span>
                            </x-table-data>
                            @can('isAdmin')
                                <x-table-data class="flex gap-3">
                                    <a href="{{ route(auth()->user()->roleName . 'transaction.edit', $transaction) }}"
                                        class="flex items-center gap-2 hover:text-blue-500">
                                        <span>
                                            <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 576 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                                                <title>Edit</title>
                                                <path
                                                    d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                </path>
                                            </svg>
                                        </span>
                                    </a>
                                    <x-delete-confirmation-modal :values="$transaction" :message="'Are you sure you want to remove this transaction ?'"
                                        routename="{{ route(auth()->user()->roleName . 'transaction.delete', $transaction) }}" />
                                </x-table-data>
                            @endcan
                        </x-table-row>
                    @empty
                        <x-table-row>
                            <x-table-data colspan="8">
                                {{ __('No Record Found') }}
                            </x-table-data>
                        </x-table-row>
                    @endforelse
                </tbody>
            </x-table-element>
        </div>
    </section>
@endsection
