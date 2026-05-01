@extends('admin.layouts.main')

{{-- Title --}}
@push('title')
    <title>{{ __('Transaction Invoice') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div
        class="flex flex-row justify-between items-center gap-4 px-4 border-b bg-white border-gray-300 pl-6 py-2 shadow-sm text-xl font-bold">
        <div class="flex items-center gap-4">
            <a href="{{ route(auth()->user()->roleName . 'user.index') }}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFA600">
                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                </svg>
            </a>
            <div>
                <span>{{ __('Transactions') }}</span>
                <span class="block text-xs font-normal text-gray-500 mt-2">
                    <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a> &raquo;
                    <a href="{{ route(auth()->user()->roleName . 'user.index') }}">{{ __('Members') }}</a> &raquo;
                    <a href="{{ route(auth()->user()->roleName . 'transaction.index', $user) }}">{{ __('Transaction') }}</a>
                    &raquo;
                    <a>{{ __('Invoice') }}</a>
                </span>
            </div>
        </div>
        <a href="{{ route(auth()->user()->roleName . 'transaction.invoice.download', $user) }}" class="mr-4 flex items-center gap-2">
            <span>Download PDF</span>
            <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z">
                </path>
            </svg>
        </a>

    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2 py-6 bg-white shadow-lg rounded-md">
        <div>
            <div class="py-4">
                <!-- Company & Invoice Details -->
                <div class="flex flex-col lg:flex-row justify-between px-6 lg:px-14 py-6">
                    <!-- Logo -->
                    <div class="mb-4 lg:mb-0">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Company Logo" class="h-20 mx-auto lg:mx-0">
                    </div>
                    <!-- Invoice Info -->
                    <div class="text-sm text-right">
                        <table class="border-collapse w-full lg:w-auto">
                            <tbody>
                                <tr>
                                    <td class="pr-4 lg:border-r lg:pr-4">
                                        <p class="text-gray-500">Issue Date</p>
                                        <p class="font-bold text-orange-600">{{ dateFormat(today()) }}</p>
                                    </td>
                                    <td class="pl-4 lg:pl-4 lg:pr-4 lg:border-r">
                                        <p class="text-gray-500">Invoice No. </p>
                                        <p class="font-bold text-orange-600">{{ $invoiceNumber }}</p>
                                    </td>
                                    <td class="pl-4">
                                        <p class="text-gray-500">GST No. </p>
                                        <p class="font-bold text-orange-600">{{ $branch->gst_no ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Billing Info -->
                <div class="bg-gray-100 px-6 lg:px-14 py-6 text-sm">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="flex flex-col lg:flex-row">
                                <td class="lg:w-1/2 text-gray-600 mb-4 lg:mb-0">
                                    <p class="font-bold">Invoice TO</p>
                                    <p>{{ $userProfile->fullName }}</p>
                                    <p>{{ $user->phone }}</p>
                                    <p>{{ $userProfile->gender }}</p>
                                </td>
                                <td class="lg:w-1/2 text-right text-gray-600">
                                    <p class="font-bold">Invoice From</p>
                                    <p>{{ $branch->name }}</p>
                                    <p>{{ $branch->location }}</p>
                                    <p>{{ $branch->address }}</p>
                                    <p>{{ $branch->phone }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Transaction Table -->
                <div class="px-6 lg:px-14 py-10 text-sm text-gray-700">
                    <h1 class="text-xl font-semibold mb-3 text-orange-600">Transaction Details</h1>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b py-3 pl-3">Transaction date</th>
                                <th class="border-b py-3 pl-2">Total Amount</th>
                                <th class="border-b py-3 pl-2">Amount Paid</th>
                                <th class="border-b py-3 pl-2 text-red-600">Remaining Balance</th>
                                <th class="border-b py-3 pl-2">Payment Method</th>
                            </tr>
                        </thead>
                        @foreach ($transactions as $transaction)
                            <tbody>
                                <tr>
                                    <td class="border-b py-3 pl-3 text-center">{{ $transaction->transaction_date }}</td>
                                    <td class="border-b py-3 pl-2 text-center">
                                        {{ $transaction->amount + $transaction->remaining_amount }}</td>
                                    <td class="border-b py-3 pl-2 text-center">{{ $transaction->amount }}</td>
                                    <td class="border-b py-3 pl-2 text-center text-red-600">
                                        {{ $transaction->remaining_amount ?? '0' }}</td>
                                    <td class="border-b py-3 pl-2 text-center">{{ $transaction->method_type }}</td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>

                <!-- Total Amount -->
                <div class="flex justify-end px-6 lg:px-14">
                    <table class="w-full lg:w-1/4 text-sm text-gray-700">
                        <tbody>
                            <tr>
                                <td class="text-gray-800">Grand Total:</td>
                                <td class="text-right font-bold text-orange-600">{{ $amountPaid + $remainingBalance }}</td>
                            </tr>
                            <tr>
                                <td class="text-red-600">Total Remaining Balance:</td>
                                <td class="text-right font-bold text-red-600">{{ $remainingBalance ?? '0' }}</td>
                            </tr>
                            <tr class="bg-orange-600 text-white">
                                <td class="p-3 font-bold">Total Amount Paid:</td>
                                <td class="p-3 text-right font-bold">{{ $amountPaid }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Details -->
                <div class="px-6 lg:px-14 py-6 text-sm text-gray-700">
                    <p class="font-bold text-orange-600">PAYMENT MODE USED</p>
                    <div class="flex flex-wrap gap-4">
                        <label class="p-2">
                            CASH <input type="checkbox" class="text-orange-600"
                                {{ $transactions->contains('method_type', 'Cash') ? 'checked' : '' }} disabled>
                        </label>
                        <label class="p-2">
                            UPI <input type="checkbox" class="text-orange-600"
                                {{ $transactions->contains('method_type', 'Upi') ? 'checked' : '' }} disabled>
                        </label>
                        <label class="p-2">
                            CARD <input type="checkbox" class="text-orange-600"
                                {{ $transactions->contains('method_type', 'Card') ? 'checked' : '' }} disabled>
                        </label>
                        <label class="p-2">
                            EMI <input type="checkbox" class="text-orange-600"
                                {{ $transactions->contains('method_type', 'Emi') ? 'checked' : '' }} disabled>
                        </label>
                    </div>
                </div>


                <!-- Footer -->
                <footer class="fixed bottom-0 left-0 bg-gray-100 w-full text-gray-600 text-center text-xs py-3">
                    Elite Edge Gym & Spa
                    <span class="text-gray-300 px-2">|</span>
                    {{ $branch->phone }}
                </footer>
            </div>
    </section>
@endsection
