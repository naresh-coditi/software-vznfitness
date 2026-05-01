@extends('admin.layouts.main')
{{-- Title --}}
@push('title')
    <title>{{ __(' Transactions') }}</title>
@endpush

{{-- Breadcrum --}}
@push('breadcrum')
    <div class="pl-6 py-2 mt-10  text-xl font-bold">
        <span>{{ __('Transaction Reports') }}</span>
        <span class="block text-xs font-normal text-gray-500 mt-2">
            <a href="{{ route(auth()->user()->roleName . 'dashboard') }}">{{ __('Dashboard') }}</a>
            &raquo;
            <a>{{ __('Transaction Report') }}</a>
        </span>
    </div>
@endpush

@section('main-section')
    <section class="w-full px-6 mt-2" x-data={}>
        <div class="flex items-center justify-between">
            <x-filters.trasaction-filters :paymentMethods="$paymentMethods" />
            {{-- <form action="" method="get" class="py-2 w-full flex items-center justify-between gap-6">
                <div class="w-full flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="w-full md:w-1/2">
                        <div class="flex items-end md:items-center justify-between gap-4 w-full">
                            <div class="w-full">
                                <x-text-input id="search" class="block w-full" type="search" name="search"
                                    value="{{ $request->search }}" placeholder="Search By  i.e Name, ID, Phone, Amount" />
                            </div>
                            <x-primary-button class="mt-2">{{ __('Search') }}</x-primary-button>
                        </div>
                    </div>
                    <div class="w-full flex flex-col md:flex-row items-center gap-4">
                        <div class="w-full md:w-1/2">
                            <x-input-label for="method_type" class="text-xs" :value="__('Payment Method')" />
                            <select name="method_type" id="method_type" autofocus @change="$event.target.form.submit();"
                                class="block w-full border-gray-300 focus:border-orange-600 focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="" selected>{{ __('All') }}</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method['name'] }}"
                                        {{ request('method_type') == $method['name'] ? 'selected' : '' }}>
                                        {{ $method['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-2">
                            <div class="w-full">
                                <x-input-label for="date_range" class="text-xs" :value="__('Transaction Dates')" />
                                <input type="text" name="date_range" id="date_range" value="{{ request('date_range') }}"
                                    @change="$event.target.form.submit();">
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}
            @if ($totalAmount)
                <div class="text-xl font-bold">
                    <span>Total Amount : {{ ' ₹' . $totalAmount }}</span>
                </div>
            @endif
        </div>
        <x-table-element>
            <thead class="bg-gray-50">
                <x-table-row>
                    <x-table-head>
                        {{ __('ID') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Payment From') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Phone No.') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Transaction Date') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Amount') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Payment Method') }}
                    </x-table-head>
                    <x-table-head>
                        {{ __('Created By') }}
                    </x-table-head>
                </x-table-row>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($transactions as $key => $transaction)
                    <x-table-row>
                        <x-table-data>
                            {{ $transaction->user->member_id }}
                        </x-table-data>
                        <x-table-data>
                            {{ $transaction->userProfile->fullName }}
                        </x-table-data>
                        <x-table-data>
                            {{ $transaction->user->phone }}
                        </x-table-data>
                        <x-table-data>
                            {{ dateFormat($transaction->created_at) }}
                        </x-table-data>
                        <x-table-data>
                            {{ $transaction->amount }}
                        </x-table-data>
                        <x-table-data>
                            {{ $transaction->method_type }}
                        </x-table-data>
                        <x-table-data>
                            {{ $transaction->createdByProfile->fullName }}
                        </x-table-data>
                    </x-table-row>
                @empty
                    <x-table-row>
                        <x-table-data colspan="7">
                            {{ __('No Record Found..') }}
                        </x-table-data>
                    </x-table-row>
                @endforelse
            </tbody>
        </x-table-element>
        <div class="py-3">{{ $transactions->links() }}</div>
    </section>
@endsection
@push('script')
    <script>
        $(function() {
            $('input[name="date_range"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
                $(this).closest('form').submit();
            });

            $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
